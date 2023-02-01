@extends('backEnd.master')
@section('title') 
    @lang('admin.visitor_book')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('admin.visitor_book')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('admin.admin_section')</a>
                    <a href="#">@lang('admin.visitor_book')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($visitor))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('visitor')}}" class="primary-btn small fix-gr-bg">
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
                                    <h3 class="mb-30">
                                        @if(isset($visitor))
                                            @lang('admin.edit_visitor')
                                        @else
                                            @lang('admin.add_visitor')
                                        @endif
                                       
                                    </h3>
                                </div>
                                @if(isset($visitor))
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'visitor_update',
                                    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                @else
                                  @if(userPermission(17))
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'visitor_store',
                                    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                @endif
                                @endif
                                <div class="white-box">
                                    <div class="add-visitor">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input
                                                            class="primary-input form-control{{ $errors->has('purpose') ? ' is-invalid' : '' }}"
                                                            type="text" name="purpose" autocomplete="off"
                                                            value="{{isset($visitor)? $visitor->purpose: old('purpose')}}">

                                                    <input type="hidden" name="id"
                                                           value="{{isset($visitor)? $visitor->id: ''}}">
                                                    <label>@lang('admin.purpose')<span>*</span></label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('purpose'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('purpose') }}</strong>
                                                </span>
                                                    @endif
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row mt-35">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input
                                                            class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                            type="text" name="name" autocomplete="off"
                                                            value="{{isset($visitor)? $visitor->name: old('name')}}">
                                                    <label>@lang('common.name')<span>*</span></label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row mt-35">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input oninput="phoneCheck(this)" class="primary-input form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                            type="tel" name="phone"
                                                            value="{{isset($visitor)? $visitor->phone: old('phone')}}">
                                                    <label>@lang('admin.phone')</label>
                                                    <span class="focus-border"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-35">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input class="primary-input form-control{{ $errors->has('visitor_id') ? ' is-invalid' : '' }}" type="text" name="visitor_id"
                                                           value="{{isset($visitor)? $visitor->visitor_id: old('visitor_id')}}">
                                                    <label>@lang('admin.id') *</label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('visitor_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('visitor_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-35">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input class="primary-input  form-control{{ $errors->has('no_of_person') ? ' is-invalid' : '' }}" type="text" onkeypress="return isNumberKey(event)" name="no_of_person"
                                                           value="{{isset($visitor)? $visitor->no_of_person: old('no_of_person')}}">
                                                    <label>@lang('admin.no_of_person') *</label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('no_of_person'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('no_of_person') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row no-gutters input-right-icon mt-35">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input date {{ $errors->has('date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                           name="date"
                                                           value="{{isset($visitor)? date('m/d/Y', strtotime($visitor->date)): date('m/d/Y')}}">
                                                    <label>@lang('admin.date')</label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('date'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date') }}</strong>
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

                                        <div class="row no-gutters input-right-icon mt-25">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input time form-control{{ $errors->has('in_time') ? ' is-invalid' : '' }}"
                                                           type="text" name="in_time"
                                                           value="{{isset($visitor)? $visitor->in_time: old('in_time')}}">
                                                    <label>@lang('admin.in_time') *</label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('in_time'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('in_time') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="" type="button">
                                                    <i class="ti-timer"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row no-gutters input-right-icon mt-25">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input time  form-control{{ $errors->has('out_time') ? ' is-invalid' : '' }}"
                                                           type="text" name="out_time"
                                                           value="{{isset($visitor)? $visitor->out_time: old('out_time')}}">
                                                    <label>@lang('admin.out_time') *</label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('out_time'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('out_time') }}</strong>
                                                    </span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="" type="button">
                                                    <i class="ti-timer"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row no-gutters input-right-icon mt-35">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input" id="placeholderInput" type="text"
                                                           placeholder="{{isset($visitor)? ($visitor->file != ""? getFilePath3($visitor->file):trans('common.file')):trans('common.file')}}"
                                                           readonly>
                                                          
                                                           <code>(PDF,DOC,DOCX,JPG,JPEG,PNG,TXT are allowed for upload)</code>
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
                                  if(userPermission(17) ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp

                                        <div class="row mt-40">
                                            <div class="col-lg-12 text-center">
                                               <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{ @$tooltip }}">
                                                    <span class="ti-check"></span>
                                                    @if(isset($visitor))
                                                        @lang('common.update')
                                                    @else
                                                        @lang('common.save')
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
                                <h3 class="mb-0">@lang('admin.visitor_list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                              
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('admin.no_of_person')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.purpose')</th>
                                    <th>@lang('admin.date')</th>
                                    <th>@lang('admin.in_time')</th>
                                    <th>@lang('admin.out_time')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php $count=1; @endphp
                                @foreach($visitors as $visitor)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{ @$visitor->name}}</td>
                                        <td>{{ @$visitor->no_of_person}}</td>
                                        <td>{{ @$visitor->phone}}</td>
                                        <td>{{ @$visitor->purpose}}</td>
                                        <td  data-sort="{{strtotime(@$visitor->date)}}" >{{ !empty($visitor->date)? dateConvert(@$visitor->date):''}}</td>
                                        <td>{{ @$visitor->in_time}}</td>
                                        <td>{{ @$visitor->out_time}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    @lang('admin.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(userPermission(18))

                                                        <a class="dropdown-item"
                                                           href="{{route('visitor_edit', [@$visitor->id])}}">@lang('common.edit')</a>
                                                    @endif
                                                    @if(userPermission(19))

                                                        <a class="dropdown-item" data-toggle="modal"
                                                           data-target="#deleteVisitorModal{{@$visitor->id}}"
                                                           href="#">@lang('common.delete')</a>
                                                        @if(@$visitor->file != "")
                                                            @if(userPermission(20))
                                                                @if (@file_exists($visitor->file))
                                                                        <a class="dropdown-item"
                                                                        href="{{url($visitor->file)}}" download>
                                                                            @lang('common.download') <span
                                                                                    class="pl ti-download"></span>
                                                                        </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteVisitorModal{{@$visitor->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('admin.delete_visitor') </h4>
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

                                                        <a href="{{route('visitor_delete', [@$visitor->id])}}"
                                                           class="primary-btn fix-gr-bg">@lang('common.delete')</a>

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
