@extends('backEnd.master')
@section('title')
@lang('homework.add_homework')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('homework.add_homework')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('homework.home_work')</a>
                    <a href="#">@lang('homework.add_homework')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('homework.add_homework')</h3>
                    </div>
                </div>
            </div>
            @if(userPermission(279))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'saveHomeworkData', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            @if(moduleStatusCheck('University'))
                            <div class="row mb-30">
                            @includeIf('university::common.session_faculty_depart_academic_semester_level',['subject'=>true,'dept_mt' => 'mt-0'])
                            </div>
                            @else 

                            <div class="row mb-30">
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('class_id') ? ' is-invalid' : '' }}"
                                                name="class_id" id="classSelectStudentHomeWork">
                                            <option data-display="@lang('common.select_class') *"
                                                    value="">@lang('common.select')</option>
                                            @foreach($classes as $key=>$value)
                                                <option value="{{$value->id}}" {{old('class_id') != ""? 'selected':''}}>{{$value->class_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('class_id'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('class_id') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20" id="subjectSelecttHomeworkDiv">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('subject_id') ? ' is-invalid' : '' }}"
                                                name="subject_id" id="subjectSelect">
                                            <option data-display="@lang('common.select_subjects') *"
                                                    value="">@lang('common.subject') *
                                            </option>
                                        </select>
                                        <div class="pull-right loader loader_style" id="select_subject_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('subject_id'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('subject_id') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{-- <div class="input-effect" id="m_select_subject_section_div">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }} m_select_subject_section" name="m_select_subject_section" id="sectionSelectStudent">
                                             <option data-display="@lang('common.select_section')" value="">@lang('common.section')</option>
                                             <option  value="all_section"> @lang('homework.all_section')</option>
                                         </select>
                                         <div class="pull-right loader loader_style" id="select_section_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                         <span class="focus-border"></span>
                                         @if ($errors->has('section_id'))
                                         <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('section_id') }}</strong>
                                        </span>
                                        @endif
                                    </div> --}}
                                    <div class="col-lg-12 " id="selectSectionsDiv" style="margin-top: -25px;">
                                        <label for="checkbox" class="mb-2">@lang('common.section') *</label>
                                            <select multiple id="selectSectionss" name="section_id[]" style="width:300px">
                                              
                                            </select>
                                            <div class="">
                                            <input type="checkbox" id="checkbox_section" class="common-checkbox homework-section">
                                            <label for="checkbox_section" class="mt-3">@lang('homework.select_all')</label>
                                            </div>
                                            @if ($errors->has('section_id'))
                                                <span class="invalid-feedback invalid-select" role="alert" style="display:block">
                                                    <strong style="top:-25px">{{ $errors->first('section_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                         
                            </div>
                            @endif 

                            <div class="row mb-30">
                                <div class="col-lg-3">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input date form-control{{ $errors->has('homework_date') ? ' is-invalid' : '' }}"
                                                       id="homework_date" type="text" name="homework_date"
                                                       value="{{old('homework_date') != ""? old('homework_date'): date('m/d/Y')}}"
                                                       readonly>
                                                <label>@lang('homework.home_work_date')
                                                    <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('homework_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('homework_date') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="homework_date_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                                <div class="col-lg-3">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input date form-control{{ $errors->has('submission_date') ? ' is-invalid' : '' }}"
                                                       id="submission_date" type="text" name="submission_date"
                                                       value="{{old('submission_date') != ""? old('submission_date') : date('m/d/Y')}}"
                                                       readonly>
                                                <label>@lang('homework.submission_date')
                                                    <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('submission_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('submission_date') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="submission_date_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ $errors->has('marks') ? ' is-invalid' : '' }}"
                                                       type="text" name="marks" value="{{old('marks')}}">
                                                <label>@lang('homework.marks') <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('marks'))
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('marks') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input" type="text"
                                                       id="placeholderHomeworkName"
                                                       placeholder="@lang('homework.attach_file')"
                                                       disabled>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('homework_file'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $errors->first('homework_file') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="homework_file">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="homework_file"
                                                       id="homework_file">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row md-20">
                                <div class="col-lg-12">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                            <textarea
                                                    class="primary-input form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                    cols="0" rows="4" name="description"
                                                    id="description *">{{old('description')}}</textarea>
                                        <label>@lang('common.description') <span>*</span> </label>
                                        <span class="focus-border textarea"></span>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $tooltip = "";
                            if(userPermission(279)){
                                  $tooltip = "";
                              }else{
                                  $tooltip = "You have no permission to add";
                              }
                        @endphp
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                    <span class="ti-check"></span>
                                    @lang('homework.save_homework')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </section>
@endsection
