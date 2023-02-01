@extends('backEnd.master')
@section('title') 
@lang('common.class')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('common.class')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('common.class')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($sectionId))
                @if(userPermission(266))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{route('class')}}" class="primary-btn small fix-gr-bg">
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
                                <h3 class="mb-30">@if(isset($sectionId))
                                        @lang('academics.edit_class')
                                    @else
                                        @lang('academics.add_class')
                                    @endif
                                   
                                </h3>
                            </div>
                            @if(isset($sectionId))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_update', 'method' => 'POST']) }}
                            @else
                                @if(userPermission(266))

                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_store', 'method' => 'POST']) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                       type="text" name="name" autocomplete="off"
                                                       value="{{isset($classById)? @$classById->class_name: ''}}">
                                                <input type="hidden" name="id"
                                                       value="{{isset($classById)? $classById->id: ''}}">
                                                <label>@lang('common.name') <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                   
                                    @if (generalSetting()->result_type == 'mark')
                                    <div class="row mt-30">
                                        <div class="col-lg-12"> 
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                       type="text" name="pass_mark" autocomplete="off"
                                                       value="{{isset($classById)? @$classById->pass_mark: ''}}">
                                                <label>@lang('exam.pass_mark') <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('pass_mark'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('pass_mark') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif 
                                    <div class="row mt-30">
                                        <div class="col-lg-12">
                                            <label>@lang('common.section')*</label><br>
                                            @foreach($sections as $section)
                                                <div class="">
                                                    @if(isset($sectionId))
                                                        <input type="checkbox" id="section{{@$section->id}}"
                                                               class="common-checkbox form-control{{ @$errors->has('section') ? ' is-invalid' : '' }}"
                                                               name="section[]"
                                                               value="{{@$section->id}}" {{in_array(@$section->id, @$sectionId)? 'checked': ''}}>
                                                        <label for="section{{@$section->id}}">@lang('common.section') {{@$section->section_name}}</label>
                                                    @else
                                                        <input type="checkbox" id="section{{@$section->id}}"
                                                               class="common-checkbox form-control{{ @$errors->has('section') ? ' is-invalid' : '' }}"
                                                               name="section[]" value="{{@$section->id}}">
                                                        <label for="section{{@$section->id}}">@lang('common.section') {{@$section->section_name}}</label>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($errors->has('section'))
                                                <span class="text-danger validate-textarea-checkbox" role="alert">
                                                <strong>{{ @$errors->first('section') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @php
                                        $tooltip = "";
                                        if(userPermission(266)){
                                              $tooltip = "";
                                          }else{
                                              $tooltip = "You have no permission to add";
                                          }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                    title="{{$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($sectionId))
                                                    @lang('academics.update_class')
                                                @else
                                                    @lang('academics.save_class')
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
                                <h3 class="mb-0">@lang('academics.class_list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                            
                                <tr>
                                    <th>@lang('common.class')</th>
                                    <th>@lang('common.section')</th>
                                    @if (@generalSetting()->result_type == 'mark')
                                    <th>@lang('exam.pass_mark')</th>
                                    @endif 
                                    <th>@lang('student.students')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $class)
                                    <tr>
                                        <td valign="top">{{@$class->class_name}}</td>
                                        <td>
                                            @if(@$class->groupclassSections)
                                                @foreach ($class->groupclassSections as $section)
                                                 <a href="{{route('sorting_student_list_section',[$class->id,$section->sectionName->id])}}">{{@$section->sectionName->section_name}}-({{total_no_records($class->id, $section->sectionName->id)}})</a> 
                                                 {{ !$loop->last ? ', ':'' }}
                                                @endforeach
                                            @endif
                                        </td>
                                        @if (@generalSetting()->result_type == 'mark')
                                        <td>
                                            {{$class->pass_mark}}
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{route('sorting_student_list',[$class->id])}}">{{$class->records_count}}</a>
                                        </td>



                                        <td valign="top">
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(userPermission(263))
                                                        <a class="dropdown-item"
                                                           href="{{route('class_edit', [@$class->id])}}">@lang('common.edit')</a>
                                                    @endif
                                                    @if(userPermission(264))
                                                        <a class="dropdown-item" data-toggle="modal"
                                                           data-target="#deleteClassModal{{@$class->id}}"
                                                           href="{{route('class_delete', [@$class->id])}}">@lang('common.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade admin-query" id="deleteClassModal{{@$class->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('academics.delete_class')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">@lang('common.cancel')</button>
                                                        <a href="{{route('class_delete', [$class->id])}}"
                                                           class="text-light">
                                                            <button class="primary-btn fix-gr-bg"
                                                                    type="submit">@lang('common.delete')</button>
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
