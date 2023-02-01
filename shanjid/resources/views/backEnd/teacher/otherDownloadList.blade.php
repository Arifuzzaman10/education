@extends('backEnd.master')
@section('title') 
@lang('study.other_downloads_list')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('study.other_downloads_list') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('study.study_material')</a>
                <a href="#">@lang('study.other_downloads_list')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">@lang('study.other_downloads_list')</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                    <thead>
                
                        <tr>
                            <th>@lang('study.content_title')</th>
                            <th>@lang('common.type')</th>
                            <th>@lang('common.date')</th>
                            <th>@lang('study.available_for')</th>
                            @if(moduleStatusCheck('University'))
                            <th> @lang('university::un.semester_label')</th>
                            @else 
                            <th> @lang('study.classSec')</th>
                            @endif 
                            <th>@lang('common.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($uploadContents))
                        @foreach($uploadContents as $value)
                        <tr>

                            <td>{{@$value->content_title}}</td>
                            <td>
                                @if(@$value->content_type == 'as')
                                    {{__('study.assignment')}}
                                @elseif(@$value->content_type == 'st')
                                    {{__('study.study_material')}}
                                @elseif(@$value->content_type == 'sy')
                                    {{__('study.syllabus')}}
                                @else
                                    {{__('study.other_download')}}
                                @endif
                            </td>
                            <td data-sort="{{strtotime(@$value->upload_date)}}" >
                               {{@$value->upload_date != ""? dateConvert(@$value->upload_date):''}}
                            </td>
                            <td>
                                @if(moduleStatusCheck('University'))
                                    @lang('study.all_students_of') {{ @$value->semesterLabel->name  . '(' . @$value->undepartment->name . ')' }}

                                @else 
                                    @if(@$value->available_for_admin == 1)
                                        @lang('study.all_admins')<br>
                                    @endif
                                    @if(@$value->available_for_all_classes == 1)
                                        @lang('study.all_classes_student')
                                    @endif

                                    @if(@$value->classes != "" && $value->sections != "")
                                        @lang('study.all_students_of') ({{@$value->classes->class_name.'->'.@$value->sections->section_name}})
                                    @endif
                                    @if(@$value->classes != "" && $value->section ==null)
                                    @lang('study.all_students_of') ({{@$value->classes->class_name.'->'}} @lang('study.all_sections'))
                                    @endif
                                @endif     
                            </td>
                            <td>
                                @if(moduleStatusCheck('University'))
                                {{ $value->semesterLabel->name }} -({{@$value->unAcademic->name}})
                                @else 
                                    @if(@$value->classes != "")
                                        {{@$value->classes->class_name}}
                                    @endif
                                    @if($value->sections != "")
                                        ({{@$value->sections->section_name}})
                                    @endif

                                    @if($value->section == Null)
                                    ( @lang('study.all_sections') )
                                    @endif
                                @endif

                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('common.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                     <a data-modal-size="modal-lg" title="{{ __('study.view_content_details') }}" class="dropdown-item modalLink" href="{{route('upload-content-view', $value->id)}}">@lang('common.view')</a>
                                        @if(userPermission(588))
                                            <a class="dropdown-item" href="{{route('upload-content-edit',$value->id)}}">@lang('common.edit')</a>
                                        @endif

                                     @if(userPermission(107))

                                    

                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteApplyLeaveModal{{@$value->id}}"
                                            href="#">@lang('common.delete')</a>
                                            @endif

                                            @if(userPermission(106))

                                           

                                        @if(@$value->upload_file != "")
                                         <a class="dropdown-item" href="{{url(@$value->upload_file)}}" download>
                                             @lang('common.download') <span class="pl ti-download"></span>
                                        @endif
                                        @endif
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade admin-query" id="deleteApplyLeaveModal{{@$value->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('study.delete_other_download')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                    data-dismiss="modal">@lang('common.cancel')</button>
                                                                    {{ Form::open(['route' =>'delete-upload-content', 'method' => 'POST']) }}
                                                                        <input type="hidden" name="id" value="{{@$value->id}}">
                                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                                    {{ Form::close() }}
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
