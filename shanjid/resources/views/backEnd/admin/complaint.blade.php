@extends('backEnd.master')

@section('title') 
    @lang('admin.complaint')
@endsection

@section('mainContent')
  
    <section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('admin.complaint')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('admin.admin_section')</a>
                    <a href="#">@lang('admin.complaint')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($complaint))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('complaint')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@if(isset($complaint))
                                        @lang('admin.edit_complaint')
                                    @else
                                        @lang('admin.add_complaint')
                                    @endif
                                   
                                </h3>
                            </div>
                            @if(isset($complaint))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'complaint/'.@$complaint->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                             @if(userPermission(22))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'complaint',
                                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input form-control{{ @$errors->has('complaint_by') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text"
                                                    name="complaint_by"
                                                    value="{{isset($complaint)? $complaint->complaint_by: old('complaint_by')}}">
                                                <label>@lang('admin.complaint_by') <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('complaint_by'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('complaint_by') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="{{isset($complaint)? $complaint->id: ''}}">
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ @$errors->has('complaint_type') ? ' is-invalid' : '' }}"
                                                name="complaint_type">
                                                <option data-display="@lang('admin.complaint_type') *" value="">@lang('admin.type') *</option>
                                                @foreach($complaint_types as $complaint_type)
                                                    @if(isset($complaint))
                                                        <option
                                                            value="{{@$complaint_type->id}}" {{@$complaint_type->id == @$complaint->complaint_type? 'selected':''}}>{{@$complaint_type->name}}</option>
                                                    @else
                                                        <option
                                                            value="{{@$complaint_type->id}}" {{old('complaint_type') == @$complaint_type->id? 'selected':''}}>{{@$complaint_type->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                            @if ($errors->has('complaint_type'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('complaint_type') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ @$errors->has('complaint_source') ? ' is-invalid' : '' }}"
                                                name="complaint_source">
                                                <option data-display="@lang('admin.complaint_source') *" value="">@lang('admin.complaint_source') *
                                                </option>
                                                @foreach($complaint_sources as $complaint_source)
                                                    @if(isset($complaint))
                                                        <option
                                                            value="{{@$complaint_source->id}}" {{@$complaint_source->id == @$complaint->complaint_source? 'selected':''}}>{{@$complaint_source->name}}</option>
                                                    @else
                                                        <option
                                                            value="{{@$complaint_source->id}}">{{@$complaint_source->name}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                            @if ($errors->has('complaint_source'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('complaint_source') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input oninput="phoneCheck(this)" class="primary-input form-control{{ @$errors->has('phone') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text"
                                                    name="phone" value="{{isset($complaint)? $complaint->phone: ''}}">
                                                <label>@lang('admin.phone')</label>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters input-right-icon mt-25">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input date form-control{{ @$errors->has('date') ? ' is-invalid' : '' }}"
                                                    id="startDate" type="text" name="date"
                                                    value="{{isset($complaint)? date('m/d/Y', strtotime($complaint->date)): (old('date') != ""? old('date'):date('m/d/Y'))}}">
                                                <label>@lang('admin.date') <span></span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('date'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('date') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input form-control{{ @$errors->has('action_taken') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text"
                                                    name="action_taken"
                                                    value="{{isset($complaint)? $complaint->action_taken: old('action_taken')}}">
                                                <label>@lang('admin.actions_taken') </label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('action_taken'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('action_taken') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input form-control{{ @$errors->has('assigned') ? ' is-invalid' : '' }}"
                                                    id="apply_date" type="text" name="assigned"
                                                    value="{{isset($complaint)? $complaint->assigned: old('assigned')}}">
                                                <label>@lang('admin.assigned')</label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('assigned'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('assigned') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                @isset($complaint)
                                                    <textarea class="primary-input form-control" cols="0" rows="4"
                                                              name="description">{{ @$complaint->description}}</textarea>
                                                @else
                                                    <textarea class="primary-input form-control" cols="0" rows="4"
                                                              name="description">{{old('description')}}</textarea>
                                                @endif
                                                <span class="focus-border textarea"></span>
                                                <label>@lang('admin.description') <span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters input-right-icon mt-35">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input" id="placeholderInput" type="text"
                                                       placeholder="{{isset($complaint)? ($complaint->file != ""? getFilePath3($complaint->file):trans('common.file')):trans('common.file')}}"
                                                       readonly>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="browseFile">@lang('common.browse')</label>
                                                <input type="file" class="d-none" id="browseFile" name="file">
                                            </button>
                                        </div>
                                    </div>
                                @php 
                                  $tooltip = "";
                                  if(userPermission(22) ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                           <button class="primary-btn fix-gr-bg now_wrap_lg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($complaint))
                                                    @lang('admin.update_complaint')
                                                @else
                                                    @lang('admin.save_complaint')
                                                @endif
                                              
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('admin.complaint') @lang('admin.list')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                              
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>@lang('admin.complaint_by')</th>
                                    <th>@lang('admin.complaint_type')</th>
                                    <th>@lang('admin.source')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.date')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$complaints as $key=>$complaint)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{@$complaint->complaint_by}}</td>
                                        <td>{{isset($complaint->complaint_type)? @$complaint->complaintType->name:''}}</td>
                                        <td>{{ isset($complaint->complaint_source)? @$complaint->complaintSource->name:''}}</td>

                                        <td>{{$complaint->phone}}</td>
                                        <td data-sort="{{strtotime(@$complaint->date)}}">{{ !empty(@$complaint->date)? dateConvert(@$complaint->date):''}} </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(userPermission(26))

                                                    <a class="dropdown-item modalLink" title="{{ __('admin.complaint_details') }}"
                                                       data-modal-size="large-modal"
                                                       href="{{url('complaint', [@$complaint->id])}}">@lang('common.view')</a>
                                                    @endif
                                                       @if(userPermission(23))

                                                       <a class="dropdown-item"
                                                       href="{{url('complaint/'.@$complaint->id.'/edit')}}">@lang('common.edit')</a>
                                                   @endif
                                                   @if(userPermission(24))

                                                       <a class="dropdown-item" data-toggle="modal"
                                                       data-target="#deleteComplaintModal{{$complaint->id}}"
                                                       href="#">@lang('common.delete')</a>
                                                    @endif
                                                       @if(@$complaint->file != "")
                                                     @if(userPermission(25))
                                                   @if (@file_exists($complaint->file))
                                                        <a class="dropdown-item"
                                                            href="{{url(@$complaint->file)}}" download>
                                                                @lang('common.download') <span class="pl ti-download"></span>
                                                        </a>
                                                    @endif    
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteComplaintModal{{@$complaint->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('admin.delete_complaint')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    </div>
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">@lang('common.cancel')
                                                        </button>
                                                        {{ Form::open(['url' => 'complaint/'.$complaint->id, 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')
                                                        </button>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
