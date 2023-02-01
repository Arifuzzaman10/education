@extends('backEnd.master')
@section('title') 
@lang('student.student_admission')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('public/backEnd/')}}/css/croppie.css">
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('student.student_admission')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('student.student_information')</a>
                <a href="#">@lang('student.student_admission')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="main-title xs_mt_0 mt_0_sm">
                    <h3 class="mb-0">@lang('student.add_student')</h3>
                </div>
            </div>
              @if(userPermission(63))
               <div class="offset-lg-3 col-lg-3 text-right mb-20 col-sm-6">
                <a href="{{route('import_student')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('student.import_student')
                </a>
            </div>
            @endif
        </div>
        @if(userPermission(65))
            {{ Form::open(['class' => 'form-horizontal studentadmission', 'files' => true, 'route' => 'student_store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
        @endif
        <div class="row">
            <div class="col-lg-12">
                
                <div class="white-box">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                @if($errors->any())
                                    <div class="error text-danger ">{{ 'Something went wrong, please try again' }}</div>
                                    @foreach ($errors->all() as $error)
                                    @if($error == "The email address has already been taken.")
                                        <div class="error text-danger ">{{ 'The email address has already been taken, You can find out in student list or disabled student list' }}</div>
                                        @else
                                            <div class="error text-danger ">{{ $error }}</div>
                                        @endif
                                    @endforeach
                                @endif
                                @if ($errors->any())

                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('student.personal_info')</h4>
                                </div>
                            </div>
                        </div>
 
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                     
                        <div class="row mb-40 mt-30">
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('session') ? ' is-invalid' : '' }}" name="session" id="academic_year">
                                        <option data-display="@lang('common.academic_year') @if(is_required('session')==true) * @endif" value="">@lang('common.academic_year') @if(is_required('session')==true) * @endif</option>
                                        @foreach($sessions as $session)
                                        <option value="{{$session->id}}" {{old('session') == $session->id? 'selected': ''}}>{{$session->year}}[{{$session->title}}]</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('session'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('session') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="class-div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" name="class" id="classSelectStudent">
                                        <option data-display="@lang('common.class') @if(is_required('class')==true) * @endif" value="">@lang('common.class') @if(is_required('class')==true) * @endif</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_class_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                           
                           
                            @if(!empty(old('class')))
                            @php
                                $old_sections = DB::table('sm_class_sections')->where('class_id', '=', old('class'))
                                ->join('sm_sections','sm_class_sections.section_id','=','sm_sections.id')
                                ->get();
                            @endphp
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="sectionStudentDiv">
                                    <select class="niceSelect w-100 bb form-control {{ $errors->has('section') ? ' is-invalid' : '' }}" name="section"
                                        id="sectionSelectStudent" >
                                       <option data-display="@lang('common.section') @if(is_required('section')==true) * @endif" value="">@lang('common.section') @if(is_required('section')==true) * @endif</option>
                                        @foreach ($old_sections as $old_section)
                                           <option value="{{ $old_section->id }}" {{ old('section')==$old_section->id ? 'selected' : '' }} >
                                            {{ $old_section->section_name }}</option>
                                      @endforeach
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @else

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="sectionStudentDiv">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" name="section" id="sectionSelectStudent">
                                       <option data-display="@lang('common.section') @if(is_required('section')==true) * @endif" value="">@lang('common.section') @if(is_required('section')==true) * @endif</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(is_show('admission_number'))
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <input class="primary-input  form-control{{ $errors->has('admission_number') ? ' is-invalid' : '' }}" type="text" onkeyup="GetAdmin(this.value)" name="admission_number"
                                     value="{{$max_admission_id != ''? $max_admission_id + 1 : 1}}" >

                                   <label>@lang('student.admission_number') @if(is_required('admission_number')==true) * @endif</label>
                                    <span class="focus-border"></span>
                                    <span class="invalid-feedback" id="Admission_Number" role="alert">
                                    </span>
                                    @if ($errors->has('admission_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('admission_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(is_show('roll_number'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input oninput="numberCheck(this)" class="primary-input" type="text" id="roll_number" name="roll_number"  value="{{old('roll_number')}}">
                                    <label> {{ moduleStatusCheck('Lead')==true ? __('lead::lead.id_number') : __('student.roll') }}
                                         @if(is_required('roll_number')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    <span class="text-danger" id="roll-error" role="alert">
                                        <strong></strong>
                                    </span>
                                    @if ($errors->has('roll_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('roll_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                             @endif 

                        </div>
                        <div class="row mb-40">
                            @if(is_show('first_name'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" name="first_name" value="{{old('first_name')}}">
                                        <label>@lang('student.first_name')  @if(is_required('first_name')==true) <span> *</span> @endif </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(is_show('last_name'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" value="{{old('last_name')}}">
                                        <label>@lang('student.last_name')  @if(is_required('last_name')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(is_show('gender'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">                          
                                        <option data-display="@lang('common.gender') @if(is_required('gender')==true) * @endif" value="">@lang('common.gender') @if(is_required('gender')==true) <span>*</span> @endif </option>
                                        @foreach($genders as $gender)
                                        <option value="{{$gender->id}}" {{old('gender') == $gender->id? 'selected': ''}}>{{$gender->base_setup_name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('date_of_birth'))
                            <div class="col-lg-3">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                 name="date_of_birth" value="{{old('date_of_birth')}}" autocomplete="off">
                                            
                                                <label>@lang('common.date_of_birth')  @if(is_required('date_of_birth')==true) <span> *</span> @endif</label>
                                               
                                                <span class="focus-border"></span>
                                            @if ($errors->has('date_of_birth'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
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
                            </div>
                            @endif 
                        </div>
                        <div class="row mb-40">
                            @if(is_show('blood_group'))
                             <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('blood_group') ? ' is-invalid' : '' }}" name="blood_group">
                                        <option data-display="@lang('common.blood_group') @if(is_required('blood_group')==true)  * @endif" value="">@lang('common.blood_group')  @if(is_required('blood_group')==true) <span> *</span> @endif</option>
                                        @foreach($blood_groups as $blood_group)
                                        <option value="{{$blood_group->id}}" {{old('blood_group') == $blood_group->id? 'selected': '' }}>{{$blood_group->base_setup_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('blood_group'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('blood_group') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('religion'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('religion') ? ' is-invalid' : '' }}" name="religion">
                                        <option data-display="@lang('student.religion') @if(is_required('religion')==true) @endif" value="">@lang('student.religion') @if(is_required('religion')==true) <span> *</span> @endif</option>
                                        @foreach($religions as $religion)
                                        <option value="{{$religion->id}}" {{old('religion') == $religion->id? 'selected': '' }}>{{$religion->base_setup_name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('religion'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('religion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('caste'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="caste" value="{{old('caste')}}">
                                    <label>@lang('student.caste') @if(is_required('caste')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('caste'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('caste') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('email_address'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input oninput="emailCheck(this)" class="primary-input email_address form-control{{ $errors->has('email_address') ? ' is-invalid' : '' }}" id="email_address" type="text" name="email_address" value="{{old('email_address')}}">
                                    <label>@lang('common.email_address')  @if(is_required('email_address')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('email_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('phone_number'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input oninput="phoneCheck(this)" class="primary-input phone_number form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" type="tel" name="phone_number" id="phone_number" value="{{old('phone_number')}}">
                                    
                                    <label>@lang('student.phone_number')  @if(is_required('phone_number')==true) <span> *</span> @endif</label>
                                  
                                    <span class="focus-border"></span>
                                    @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                        </div>
                        <div class="ro mb-40 d-none" id="exitStudent">
                            <div class="col-lg-12">
                                <input type="checkbox" id="edit_info" value="yes" class="common-checkbox" name="edit_info">
                                <label for="edit_info" class="text-danger">@lang('student.student_already_exit_this_phone_number/email_are_you_to_edit_student_parent_info')</label>
                            </div>
                        </div>
                        <div class="row mb-40">
                            @if(is_show('admission_date'))
                            <div class="col-lg-2">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input date" id="" type="text"
                                                name="admission_date" value="{{old('admission_date') != ""? old('admission_date'):date('m/d/Y')}}" autocomplete="off">
                                            <label>@lang('student.admission_date')</label>
                                            <span class="focus-border">  @if(is_required('admission_date')==true) <span> *</span> @endif</span>
                                            @if ($errors->has('admission_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('admission_date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="admission-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif 
                            @if(is_show('student_category_id'))
                            <div class="col-lg-4">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('student_category_id') ? ' is-invalid' : '' }}" name="student_category_id">
                                        <option data-display="@lang('student.category')  @if(is_required('student_category_id')==true) * @endif" value="">@lang('student.student_category_id')  @if(is_required('category')==true) <span> *</span> @endif</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('student_category_id') == $category->id? 'selected': ''}}>{{$category->category_name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('student_category_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('student_category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            @endif 
                            @if(is_show('student_group_id'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('student_group_id') ? ' is-invalid' : '' }}" name="student_group_id">
                                        <option data-display="@lang('student.group')  @if(is_required('student_group_id')==true) * @endif" value="">@lang('student.group')  @if(is_required('student_group_id')==true) <span> *</span> @endif</option>
                                        @foreach($groups as $group)
                                        <option value="{{$group->id}}" {{old('student_group_id') == $group->id? 'selected': ''}}>{{$group->group}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('student_group_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('student_group_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            @endif 
                            @if(is_show('height'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="height" value="{{old('height')}}">
                                    <label>@lang('student.height_in'))  @if(is_required('height')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('height'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('height') }}</strong>
                                            </span>
                                            @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('weight'))
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="weight" value="{{old('weight')}}">
                                    <label>@lang('student.weight_kg')  @if(is_required('weight')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('weight'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                        </div>
                        @if(moduleStatusCheck('Lead')==true)
                            <div class="row mb-40">
                                @if(is_show('source_id'))                           
                                <div class="col-lg-4 ">
                                    <div class="input-effect">
                                            <select class="niceSelect w-100 bb form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="source_id" id="source_id">
                                                <option data-display="@lang('lead::lead.source') @if(is_required('source_id')==true) * @endif" value="">@lang('lead::lead.source') @if(is_required('source_id')==true) <span> *</span> @endif</option>
                                                @foreach($sources as $source)
                                                <option value="{{$source->id}}" {{old('source_id') == $source->id? 'selected': ''}}>{{$source->source_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('source_id'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('source_id') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                </div>
                                @endif 
                            </div>
                        @endif
                        <div class="row mb-40">
                            @if(is_show('photo'))  
                            <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderPhoto" placeholder="@lang('common.student_photo')  @if(is_required('photo')==true) * @endif"
                                                readonly="">
                                            <span class="focus-border"></span>

                                            @if ($errors->has('photo'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ @$errors->first('photo') }}</strong>
                                                </span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="photo">@lang('common.browse')</label>
                                            <input type="file" class="d-none" value="{{ old('photo') }}" name="photo" id="photo">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif 
                            @if(generalSetting()->with_guardian)
                            @if(is_show('guardians_email') || is_show('guardians_phone'))
                            <div class="col-lg-6 text-right">
                                <div class="row">
                                    <div class="col-lg-7 text-left" id="parent_info">
                                        <input type="hidden" name="parent_id" value="">

                                    </div>
                                    <div class="col-lg-5">
                                        <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button" data-toggle="modal" data-target="#editStudent">
                                            <span class="ti-plus pr-2"></span>
                                            @lang('student.add_parents')
                                        </button>
                                    </div>
                                </div>

                            </div>
                            @endif 
                            @endif 
                        </div>
                        @if(generalSetting()->with_guardian)
                        <!-- Start Sibling Add Modal -->
                        <div class="modal fade admin-query" id="editStudent">
                            <div class="modal-dialog small-modal modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('student.select_sibling')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="d-flex radio-btn-flex">
                                                            <div class="mr-30">
                                                                <input type="radio" name="subject_type" id="siblingParentRadio" value="sibling" class="common-radio relationButton addParent" checked>
                                                                <label for="siblingParentRadio">@lang('student.From Sibling')</label>
                                                            </div>
                                                            @if(teacherParentService()==true)
                                                            <div class="mr-30">
                                                                <input type="radio" name="subject_type" id="staffParentRadio" value="staff" class="common-radio relationButton addParent">
                                                                <label for="staffParentRadio">@lang('student.From Staff')</label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-25" id="siblingParent">
                                                    <div class="col-lg-12">

                                                        <div class="row">
                                                            <div class="col-lg-12" id="sibling_required_error">

                                                            </div>
                                                        </div>
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_class_div">
                                                                <select class="niceSelect w-100 bb" name="sibling_class" id="select_sibling_class">
                                                                    <option data-display="@lang('student.class') *" value="">@lang('student.class') *</option>
                                                                    @foreach($classes as $class)
                                                                    <option value="{{$class->id}}" {{old('sibling_class') == $class->id? 'selected': '' }} >{{$class->class_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_section_div">
                                                                <select class="niceSelect w-100 bb" name="sibling_section" id="select_sibling_section">
                                                                    <option data-display="@lang('common.section') *" value="">@lang('common.section') *</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_name_div">
                                                                <select class="niceSelect w-100 bb" name="select_sibling_name" id="select_sibling_name">
                                                                    <option data-display="@lang('student.sibling') *" value="">@lang('student.sibling') *</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-25 d-none" id="staffParent">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="staff_class_div">
                                                                <select class="niceSelect w-100 bb" name="staff_parent" id="select_staff_parent">
                                                                    <option data-display="@lang('hr.select_staff') *" value="">@lang('hr.select_staff') *</option>
                                                                    @foreach($staffs as $staff)
                                                                    <option value="{{$staff->id}}" {{old('staff_parent') == $staff->id? 'selected': '' }} >{{$staff->full_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center mt-40">
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>

                                                            <button class="primary-btn fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button">@lang('common.save_information')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Sibling Add Modal -->
                        <div class="parent_details" id="parent_details">
                            
                            <div class="row mt-40">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h4 class="stu-sub-head">@lang('student.parents_and_guardian_info') </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-40 mt-30">
                                @if(is_show('fathers_name'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}" type="text" name="fathers_name" id="fathers_name" value="{{old('fathers_name')}}">
                                        <label>@lang('student.father_name')  @if(is_required('father_name')==true) <span> *</span> @endif </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('fathers_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fathers_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('fathers_occupation'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input" type="text" name="fathers_occupation" id="fathers_occupation" value="{{old('fathers_occupation')}}">
                                        <label>@lang('student.occupation') @if(is_required('fathers_occupation')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('fathers_occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fathers_occupation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('fathers_phone'))
                                 <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="phoneCheck(this)" class="primary-input form-control{{ $errors->has('fathers_phone') ? ' is-invalid' : '' }}" type="text" name="fathers_phone" id="fathers_phone" value="{{old('fathers_phone')}}">
                                        <label>@lang('student.father_phone')  @if(is_required('father_phone')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('fathers_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fathers_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('fathers_photo'))
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input" type="text" id="placeholderFathersName" placeholder="@lang('common.photo') @if(is_required('fathers_photo')==true) * @endif"
                                                    readonly="">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('fathers_photo'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('fathers_photo') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="fathers_photo">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="fathers_photo" id="fathers_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif 
                            </div>
                            <div class="row mb-30">
                                @if(is_show('mothers_name'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}" type="text" name="mothers_name" id="mothers_name" value="{{old('mothers_name')}}">
                                        <label>@lang('student.mother_name')  @if(is_required('mothers_name')==true) <span> *</span> @endif </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('mothers_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mothers_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('mothers_occupation'))
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input" type="text" name="mothers_occupation" id="mothers_occupation" value="{{old('mothers_occupation')}}">
                                        <label>@lang('student.occupation') @if(is_required('mothers_occupation')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('mothers_occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mothers_occupation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('mothers_phone'))
                                 <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="phoneCheck(this)" class="primary-input form-control{{ $errors->has('mothers_phone') ? ' is-invalid' : '' }}" type="text" name="mothers_phone" id="mothers_phone" value="{{old('mothers_phone')}}">
                                        <label>@lang('student.mother_phone')  @if(is_required('mothers_phone')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('mothers_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mothers_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('mothers_photo'))
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input" type="text" id="placeholderMothersName" placeholder="@lang('student.photo')  @if(is_required('mothers_photo')==true) * @endif"
                                                    readonly="">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('mothers_photo'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('mothers_photo') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="mothers_photo">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="mothers_photo" id="mothers_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif 
                            </div>

                            @if(is_show('guardians_email') || is_show('guardians_phone')) 
                            <div class="row mb-40">                             
                                <div class="col-lg-12 d-flex flex-wrap">
                                    <p class="text-uppercase fw-500 mb-10">@lang('student.relation_with_guardian')</p>
                                    <div class="d-flex radio-btn-flex ml-40 mt-15">
                                        <div class="mr-30">
                                            <input type="radio" name="relationButton" id="relationFather" value="F" class="common-radio relationButton" {{old('relationButton') == "F"? 'checked': ''}}>
                                            <label for="relationFather">@lang('student.father')</label>
                                        </div>
                                        <div class="mr-30">
                                            <input type="radio" name="relationButton" id="relationMother" value="M" class="common-radio relationButton" {{old('relationButton') == "M"? 'checked': ''}}>
                                            <label for="relationMother">@lang('student.mother')</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="relationButton" id="relationOther" value="O" class="common-radio relationButton"  {{old('relationButton') != ""? (old('relationButton') == "O"? 'checked': ''): 'checked'}}>
                                            <label for="relationOther">@lang('student.Other')</label>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                            @endif 
                            <div class="row mb-40">
                                @if(is_show('guardians_name')) 
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('guardians_name') ? ' is-invalid' : '' }}" type="text" name="guardians_name" id="guardians_name" value="{{old('guardians_name')}}">
                                        <label>@lang('student.guardian_name')  @if(is_required('guardians_name')==true) <span> *</span> @endif </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('guardians_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('guardians_email') || is_show('guardians_phone')) 
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input read-only-input" type="text" placeholder="Relation" name="relation" id="relation" value="Other" readonly>
                                        <label>@lang('student.relation_with_guardian') @if(is_required('relation')==true) <span> *</span> @endif </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('relation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('relation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('guardians_email')) 
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="emailCheck(this)" class="primary-input form-control{{ $errors->has('guardians_email') ? ' is-invalid' : '' }}" type="text" name="guardians_email" id="guardians_email" value="{{old('guardians_email')}}">
                                        <label>@lang('student.guardian_email') @if(is_required('guardians_email')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('guardians_email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('guardians_photo')) 
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input" type="text" id="placeholderGuardiansName" placeholder="@lang('student.photo') @if(is_required('guardians_photo')==true) * @endif"
                                                    readonly="">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('guardians_photo'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('guardians_photo') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="guardians_photo">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="guardians_photo" id="guardians_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif 
                            </div>
                            <div class="row mb-30">
                                @if(is_show('guardians_phone')) 
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('guardians_phone') ? ' is-invalid' : '' }}" type="text" name="guardians_phone" id="guardians_phone" value="{{old('guardians_phone')}}">
                                        <label>@lang('student.guardian_phone')@if(is_required('guardians_phone')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ @$errors->first('guardians_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if(is_show('guardians_occupation')) 
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input" type="text" name="guardians_occupation" id="guardians_occupation" value="{{old('guardians_occupation')}}">
                                        <label>@lang('student.guardian_occupation') @if(is_required('guardians_occupation')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ @$errors->first('guardians_occupation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                            </div>
                            <div class="row mb-40 mt-40">
                                @if(is_show('guardians_address'))
                                <div class="col-lg-6">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <textarea class="primary-input form-control" cols="0" rows="3" name="guardians_address" id="guardians_address">{{old('guardians_address')}}</textarea>
                                        <label>@lang('student.guardian_address') @if(is_required('guardians_address')==true) <span> *</span> @endif </label>
                                        <span class="focus-border textarea"></span>
                                       @if ($errors->has('guardians_address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('guardians_address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                            </div>
                        </div>
                        @endif 


                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('student.student_address_info')</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30 mt-30">
                            @if(moduleStatusCheck('Lead')==true)
                            @if(is_show('lead_city'))
                            <div class="col-lg-4 ">
                                <div class="input-effect" style="margin-top:53px !important">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="lead_city" id="lead_city">
                                        <option data-display="@lang('lead::lead.city') @if(is_required('lead_city')==true) * @endif" value="">@lang('lead::lead.city') @if(is_required('lead_city')==true) <span> *</span> @endif</option>
                                        @foreach($lead_city as $city)
                                        <option value="{{$city->id}}" {{old('lead_city') == $city->id? 'selected': ''}}>{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('lead_city'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('lead_city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @endif
                            @if(is_show('current_address'))
                            <div class="col-lg-4">
                                <div class="input-effect sm2_mb_20 md_mb_20 mt-20">
                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="current_address" id="current_address">{{old('current_address')}}</textarea>
                                    <label>@lang('student.current_address') @if(is_required('current_address')==true) <span> *</span> @endif </label>
                                    <span class="focus-border textarea"></span>
                                   @if ($errors->has('current_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('current_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('permanent_address'))
                             <div class="col-lg-4">
                                <div class="input-effect sm2_mb_20 md_mb_20 mt-20">
                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="permanent_address" id="permanent_address">{{old('permanent_address')}}</textarea>
                                    <label>@lang('student.permanent_address')  @if(is_required('permanent_address')==true) <span> *</span> @endif </label>
                                    <span class="focus-border textarea"></span>
                                   @if ($errors->has('permanent_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('permanent_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('student.transport')</h4>
                                </div>
                            </div>
                        </div>

                         <div class="row mb-40 mt-30">
                            @if(is_show('route'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="route" id="route">
                                        <option data-display="@lang('student.route_list') @if(is_required('route')==true) * @endif" value="">@lang('student.route_list') @if(is_required('route')==true) <span> *</span> @endif</option>
                                        @foreach($route_lists as $route_list)
                                        <option value="{{$route_list->id}}" {{old('route') == $route_list->id? 'selected': ''}}>{{$route_list->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('route'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('route') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('vehicle'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="select_vehicle_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('vehicle') ? ' is-invalid' : '' }}" name="vehicle" id="selectVehicle">
                                        <option data-display="@lang('student.vehicle_number') @if(is_required('vehicle')==true) * @endif" value="">@lang('student.vehicle_number') @if(is_required('vehicle')==true) <span> *</span> @endif</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_transport_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('vehicle'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('vehicle') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> 
                            @endif 
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('student.Other_info')</h4>
                                </div>
                            </div>
                        </div>
                         <div class="row mb-40 mt-30">
                            @if(is_show('dormitory_name'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('dormitory_name') ? ' is-invalid' : '' }}" name="dormitory_name" id="SelectDormitory">
                                        <option data-display="@lang('dormitory.dormitory_name') @if(is_required('dormitory_name')==true) * @endif" value="">@lang('dormitory.dormitory_name') @if(is_required('dormitory_name')==true) <span> *</span> @endif</option >
                                        @foreach($dormitory_lists as $dormitory_list)
                                        <option value="{{$dormitory_list->id}}" {{old('dormitory_name') == $dormitory_list->id? 'selected': ''}}>{{$dormitory_list->dormitory_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('dormitory_name'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('dormitory_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('room_number'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="roomNumberDiv">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('room_number') ? ' is-invalid' : '' }}" name="room_number" id="selectRoomNumber">
                                        <option data-display="@lang('academics.room_number') @if(is_required('room_number')==true) <span> *</span> @endif" value="">@lang('academics.room_number') @if(is_required('room_number')==true) <span> *</span> @endif</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_dormitory_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('room_number'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('room_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('student.document_info')</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30 mt-30">
                            @if(is_show('national_id_number'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('national_id_number') ? ' is-invalid' : '' }}" type="text" name="national_id_number" value="{{old('national_id_number')}}">
                                    <label>@lang('common.national_id_number') @if(is_required('national_id_number')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('national_id_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('national_id_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('local_id_number'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="local_id_number" value="{{old('local_id_number')}}">
                                    <label> @lang('common.birth_certificate_number')@if(is_required('local_id_number')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('local_id_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('local_id_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('bank_account_number'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="bank_account_number" value="{{old('bank_account_number')}}">
                                    <label>@lang('accounts.bank_account_number')@if(is_required('bank_account_number')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('bank_account_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                            @if(is_show('bank_name'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="bank_name" value="{{old('bank_name')}}">
                                    <label>@lang('student.bank_name') @if(is_required('bank_name')==true) <span> *</span> @endif </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('bank_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif 
                        </div>
                        <div class="row mb-40">
                            @if(is_show('previous_school_details'))
                            <div class="col-lg-6">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <textarea class="primary-input form-control" cols="0" rows="3" name="previous_school_details">{{old('previous_school_details')}}</textarea>
                                    <label>@lang('student.previous_school_details')@if(is_required('previous_school_details')==true) <span> *</span> @endif</label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('previous_school_details'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('previous_school_details') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(is_show('additional_notes'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <textarea class="primary-input form-control" cols="0" rows="3" name="additional_notes">{{old('additional_notes')}}</textarea>
                                    <label>@lang('student.additional_notes') @if(is_required('additional_notes')==true) <span> *</span> @endif</label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('additional_notes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('additional_notes') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(is_show('ifsc_code'))
                            <div class="col-lg-3">
                                <div class="input-effect mt-30">
                                    <input class="primary-input form-control" type="text" name="ifsc_code" value="{{old('ifsc_code')}}">
                                    <label>@lang('student.ifsc_code') @if(is_required('ifsc_code')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('ifsc_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ifsc_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                         <div class="row mb-40 mt-30">
                            @if(is_show('document_file_1'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" type="text" name="document_title_1" value="{{old('document_title_1')}}">
                                    <label>@lang('student.document_01_title') @if(is_required('document_file_1')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('document_title_1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('document_title_1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(is_show('document_file_2'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_2" value="{{old('document_title_2')}}">
                                    <label>@lang('student.document_02_title') @if(is_required('document_file_2')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('document_title_2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('document_title_2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(is_show('document_file_3'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_3" value="{{old('document_title_3')}}">
                                    <label>@lang('student.document_03_title') @if(is_required('document_file_3')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('document_title_3'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('document_title_3') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(is_show('document_file_4'))
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_4" value="{{old('document_title_4')}}">
                                    <label>@lang('student.document_04_title') @if(is_required('document_file_4')==true) <span> *</span> @endif</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('document_title_4'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('document_title_4') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                         <div class="row mb-30">
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="01  @if(is_required('document_file_1')==true) * @endif"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('document_file_1'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('document_file_1') }}</strong>
                                                        </span>
                                                @endif

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_1">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="document_file_1" id="document_file_1">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileTwoName" placeholder="02 @if(is_required('document_file_2')==true) * @endif"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('document_file_2'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('document_file_2') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_2">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="document_file_2" id="document_file_2">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileThreeName" placeholder="03 @if(is_required('document_file_3')==true) * @endif"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('document_file_3'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('document_file_3') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_3">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="document_file_3" id="document_file_3">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileFourName" placeholder="04 @if(is_required('document_file_4')==true) * @endif"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('document_file_4'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('document_file_4') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_4">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="document_file_4" id="document_file_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(is_show('custom_field'))
                            {{-- Custom Filed Start --}}
                            
                            <div class="row mt-40">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h4 class="stu-sub-head">@lang('student.custom_field')</h4>
                                    </div>
                                </div>
                            </div>
                            @include('backEnd.studentInformation._custom_field')

                            {{-- Custom Filed End --}}
                        @endif

	                        @php 
                                  $tooltip = "";
                                  if(userPermission(65)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp


                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                               <button class="primary-btn fix-gr-bg submit" id="_submit_btn_admission" data-toggle="tooltip" title="{{$tooltip}}">
                                    <span class="ti-check"></span>
                                    @lang('student.save_student')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>
 {{-- student photo --}}
<input type="text" id="STurl" value="{{ route('student_admission_pic')}}" hidden>
 <div class="modal" id="LogoPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('student.crop_image_and_upload')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="resize"></div>
                <button class="btn rotate float-lef" data-deg="90" > 
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" > 
                <i class="ti-back-left"></i></button>
                <hr>
                
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="upload_logo">@lang('student.crop')</a>
            </div>
        </div>
    </div>
</div>
{{-- end student photo --}}

 {{-- father photo --}}

 <div class="modal" id="FatherPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('student.crop_image_and_upload')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="fa_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" > 
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" > 
                <i class="ti-back-left"></i></button>
                <hr>
                
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="FatherPic_logo">@lang('student.crop')</a>
            </div>
        </div>
    </div>
</div>
{{-- end father photo --}}
 {{-- mother photo --}}

 <div class="modal" id="MotherPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="ma_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" > 
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" > 
                <i class="ti-back-left"></i></button>
                <hr>
                
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="Mother_logo">Crop</a>
            </div>
        </div>
    </div>
</div>
{{-- end mother photo --}}
 {{-- mother photo --}}

 <div class="modal" id="GurdianPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="Gu_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" > 
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" > 
                <i class="ti-back-left"></i></button>
                <hr>                
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="Gurdian_logo">Crop</a>
            </div>
        </div>
    </div>
</div>
{{-- end mother photo --}}



@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/js/croppie.js"></script>
<script src="{{asset('public/backEnd/')}}/js/st_addmision.js"></script>
<script>
    $(document).ready(function(){
        var currentDate = new Date();
        $('#startDate').datepicker({
        format: 'mm/dd/yyyy',
        autoclose:true,
        endDate: "currentDate",
        maxDate: currentDate
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
            console.log($(this).datepicker('hide'));
        });
        $('#startDate').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
            }
        });
        
        $(document).on('change','.cutom-photo',function(){
            let v = $(this).val();
            let v1 = $(this).data("id");
            console.log(v,v1);
            getFileName(v, v1);

        });
        
        function getFileName(value, placeholder){
            if (value) {
                var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                var filename = value.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $(placeholder).attr('placeholder', '');
                $(placeholder).attr('placeholder', filename);
            }
        }
        $(document).on('change','.phone_number',function(){
           
            let email =  $("#email_address").val();
            let phone =  $(this).val();
            checkExitStudent(email, phone);
        });
        $(document).on('change','.email_address',function(){
            let email = $(this).val();
            let phone = $("#phone_number").val();
            checkExitStudent(email, phone);
        });
        function checkExitStudent(email, phone){
           var url = $("#url").val();
           var formData = {
                email : email,
                phone : phone,
            }
            $.ajax({
                type: "GET",
                data: formData,
                dataType: "json",
                url: url + "/" + "student/check-exit",
                success: function(data) {
                    if(data.student !=null) {
                        $('#exitStudent').removeClass('d-none');
                    } else {
                        $('#exitStudent').addClass('d-none');
                        $('#edit_info').prop('checked', false); 
                    }
                  
                },
                error: function(data) {
                    console.log("Error:", data);
                }

            })
        }
        $(document).on('change', '.addParent', function(){
            let  type = $(this).val();
            if (type == 'staff') {
                $('#staffParent').removeClass('d-none');
                $('#siblingParent').addClass('d-none');
            }else if(type == 'sibling'){
                $('#siblingParent').removeClass('d-none');
                $('#staffParent').addClass('d-none');
            }
        });
        
    })
</script>
@endsection
