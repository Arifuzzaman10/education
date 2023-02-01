@extends('backEnd.master')
@section('title')
@lang('exam.exam_type')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('exam.exam_type')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('exam.examination')</a>
                <a href="#">@lang('exam.exam_type')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="offset-lg-9 col-lg-3 text-right col-md-12 mb-20">
                <a href="{{route('exam')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('exam.exam_setup')
                </a>
            </div>

        </div>
        @if(isset($exam_type_edit))
         @if(userPermission(209))
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('exam-type')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($exam_type_edit))
                                    @lang('exam.edit_exam_type')
                                @else
                                    @lang('exam.add_exam_type')
                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($exam_type_edit))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'exam_type_update', 'method' => 'POST']) }}
                        @else
                         @if(userPermission(209))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'exam_type_store', 'method' => 'POST']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                       
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('exam_type_title') ? ' is-invalid' : '' }}" type="text" name="exam_type_title" autocomplete="off" value="{{isset($exam_type_edit)? $exam_type_edit->title : ''}}">
                                            <input type="hidden" name="id" value="{{isset($exam_type_edit)? $exam_type_edit->id: Request::old('exam_type_title')}}">
                                            <label> @lang('exam.exam_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('exam_type_title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('exam_type_title') }}</strong>
                                                </span>
                                            @endif
                                        </div>


                                    </div>
                                </div>  


	                            @php 
                                  $tooltip = "";
                                  if(userPermission(209)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp

                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($exam_type_edit))
                                                @lang('exam.update_exam_type')
                                            @else
                                                @lang('exam.save_exam_type')
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
                            <h3 class="mb-0 ">@lang('exam.exam_type_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                              
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>@lang('exam.exam_name')</th>
                                    {{-- <th>@lang('common.status')</th> --}}
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i=0; @endphp
                                @foreach($exams_types as $exams_type)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ @$exams_type->title}}</td>
                                    {{-- <td>{{( @$exams_type->active_status == 1) ? 'Active' : 'Inactive'}}</td>  --}}
                                    <td>
                                        <div class="dropdown-widget d-flex align-items-center flex-wrap">
                                                <div class="dropdown mr-1 mb-1">
                                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                        @lang('common.select')
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">

                                                        @if(userPermission(210))

                                                        <a class="dropdown-item" href="{{route('exam_type_edit', [$exams_type->id])}}">@lang('common.edit')</a>
                                                        @endif
                                                        @if(userPermission(211))

                                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteSubjectModal{{@$exams_type->id}}"  href="#">@lang('common.delete')</a>
                                                   @endif
                                                    </div>
                                                </div>
                                                 <a  class="primary-btn small tr-bg" href="{{route('exam-marks-setup',$exams_type->id)}}">
                                                    <span class="pl ti-settings"></span> @lang('exam.exam_setup')
                                                </a>
                                        </div>
                                    </td>
                                </tr>
                                 <div class="modal fade admin-query" id="deleteSubjectModal{{@$exams_type->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('exam.delete_exam_type')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <a href="{{route('exam_type_delete', [@$exams_type->id])}}" class="text-light">
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                     </a>
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
