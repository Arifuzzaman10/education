@extends('backEnd.master')
@section('title') 
@lang('exam.exam_time')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('exam.exam_time')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('exam.examination')</a>
                <a href="#">@lang('exam.exam_time')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($class_time))
         @if(userPermission(572))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('exam-time')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        @endif
        <div class="row">
             <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @if(isset($class_time))
                                    @lang('common.edit')
                                 @else
                                    @lang('common.add')
                                @endif
                                    @lang('exam.exam_time')
                            </h3>
                        </div>
                        @if(isset($class_time))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('examTimeUpdate',$class_time->id), 'method' => 'PUT']) }}
                        @else
                         @if(userPermission(572))
           
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'examtimeSave', 'method' => 'POST']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('period') ? ' is-invalid' : '' }}" type="text" name="period" autocomplete="off" value="{{isset($class_time)? $class_time->period: ''}}">
                                            <input type="hidden" name="id" value="{{isset($class_time)? $class_time->id: ''}}">
                                            <label>@lang('exam.exam_period') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('period'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('period') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input time form-control{{ @$errors->has('start_time') ? ' is-invalid' : '' }}" type="text" name="start_time" value="{{isset($class_time)? $class_time->start_time: old('start_time')}}">
                                            <label>@lang('exam.select_time') *</label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('start_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('start_time') }}</strong>
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
                                                <input class="primary-input time  form-control{{ @$errors->has('end_time') ? ' is-invalid' : '' }}" type="text" name="end_time"  value="{{isset($class_time)? $class_time->end_time: old('end_time')}}">
                                                <label>@lang('exam.end_time') *</label>
                                                <span class="focus-border"></span>
                                               @if ($errors->has('end_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end_time') }}</strong>
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
	                           @php 
                                  $tooltip = "";
                                  if(userPermission(572)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($class_time))
                                                @lang('common.update')
                                            @else
                                                @lang('common.save')
                                            @endif
                                            @lang('common.time')
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
                            <h3 class="mb-0">@lang('exam.exam_time_list') </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                               @if(session()->has('message-success-delete') != "" ||
                                session()->get('message-danger-delete') != "")
                                <tr>
                                    <td colspan="3">
                                         @if(session()->has('message-success-delete'))
                                          <div class="alert alert-success">
                                              {{ session()->get('message-success-delete') }}
                                          </div>
                                        @elseif(session()->has('message-danger-delete'))
                                          <div class="alert alert-danger">
                                              {{ session()->get('message-danger-delete') }}
                                          </div>
                                        @endif
                                    </td>
                                </tr>
                                 @endif
                                <tr>
                                    <th>@lang('exam.time_type')</th>
                                    <th>@lang('exam.exam_period')</th>
                                    <th>@lang('exam.start_time')</th>
                                    <th>@lang('exam.end_time')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class_times as $class_time)
                                <tr>
                                    <td valign="top">
                                        @if (@$class_time->type == 'exam')
                                            @lang('exam.exam_time')
                                        @else
                                            @lang('exam.class_time')
                                        @endif
                                    </td>
                                    <td valign="top">{{@$class_time->period}}</td>
                                    <td valign="top">{{date('h:i A', strtotime(@$class_time->start_time))}}</td>
                                    <td valign="top">{{date('h:i A', strtotime(@$class_time->end_time))}}</td>
                                    
                                    <td valign="top">
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(573))
                                                <a class="dropdown-item" href="{{route('examTimeEdit',$class_time->id)}}">@lang('common.edit')</a>
                                                @endif
                                                 @if(userPermission(574))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteClassTime{{@$class_time->id}}"  href="#">@lang('common.delete')</a>
                                           @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteClassTime{{@$class_time->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('common.delete_exam_time')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    {{ Form::open(['route' => array('class-time-delete',@$class_time->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
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
