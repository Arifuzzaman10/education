@extends('backEnd.master')
    @section('title')
        @lang('exam.add_marks')
    @endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('exam.add_marks') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('exam.examination')</a>
                <a href="{{route('marks_register')}}">@lang('exam.marks_register')</a>
                <a href="#">@lang('exam.add_marks')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('common.select_criteria') </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'marks_register_create', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                            <div class="col-lg-3 mt-30-md">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam">
                                    <option data-display="@lang('exam.select_exam') *" value="">@lang('exam.select_exam') *</option>
                                    @foreach($exam_types as $exam_type)
                                        <option value="{{$exam_type->id}}" {{isset($exam_id)? ($exam_id == $exam_type->id? 'selected':''):''}}>{{$exam_type->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('exam'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('exam') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md">
                                <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="class_subject" name="class">
                                    <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                    @foreach($classes as $class)
                                        <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{$class->class_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-3 mt-30-md" id="select_class_subject_div">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} select_class_subject" id="select_class_subject" name="subject">
                                    <option data-display="@lang('common.select_subject') *" value="">@lang('common.select_subject') *</option>
                                </select>
                                <div class="pull-right loader loader_style" id="select_subject_loader">
                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('subject'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md" id="m_select_subject_section_div">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} m_select_subject_section" id="m_select_subject_section" name="section">
                                    <option data-display="@lang('common.select_section') " value=" ">@lang('common.select_section') </option>
                                </select>
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                
            </div>
        </div>
    </div>
</section>
<section>
<section class="mt-20">
    @if (isset($students))
        <div class="container-fluid p-0">
            <div class="row mt-40">
                <div class="col-lg-6 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('exam.add_marks') | 
                        <small>@lang('exam.exam'): {{$search_info['exam_name']}}, @lang('common.class'): {{$search_info['class_name']}}, @lang('common.section'): {{$search_info['section_name']}}
                        </h3>
                    </div>
                </div>
            </div>

            {{ Form::open(['class' => 'form-horizontal', 'route' => 'marks_register_store', 'method' => 'POST', 'id' => 'marks_register_store']) }} 
            <input type="hidden" name="exam_id" value="{{$exam_id}}">
            <input type="hidden" name="class_id" value="{{$class_id}}">
            <input type="hidden" name="section_id" value="{{$section_id}}">
            <input type="hidden" name="subject_id" value="{{$subject_id}}"> 

            <div class="row">
                <div class="col-lg-12">
                    <table class="display school-table school-table-style" cellspacing="0" width="100%" >
                        <thead>
                            <tr>
                                <th rowspan="2" >@lang('student.admission_no').</th>
                                <th rowspan="2" >@lang('student.roll_no').</th>
                                <th rowspan="2" >@lang('common.class_Sec')</th>
                                <th rowspan="2" >@lang('common.student')</th>
                                <th class="text-center" colspan="{{$number_of_exam_parts + 1}}"> {{$subjectNames->subject_name}}</th> 
                                <th rowspan="2">@lang('exam.is_present')</th>
                            </tr>
                            <tr>
                                @foreach($marks_entry_form as $part)
                                <th>{{$part->exam_title}} ( {{$part->exam_mark}} ) </th>
                                @endforeach
                                <th>@lang('common.teacher') @lang('reports.remarks')</th>
                            </tr>
                        </thead>
                        <tbody>                        
                            @php $colspan = 3; $counter = 0;  @endphp
                            @foreach($students as $record)
                            @php
                                $absent_check = App\SmMarksRegister::is_absent_check($exam_id, $class_id, $record->section_id, $subject_id, $record->student_id, $record->id);
                            @endphp
                            <tr>
                                <td>
                                    <input type="hidden" name="markStore[{{$record->id}}]" value="{{$record->id}}">
                                    <input type="hidden" name="markStore[{{$record->id}}][student]" value="{{$record->student_id}}">
                                    <input type="hidden" name="markStore[{{$record->id}}][class]" value="{{$record->class_id}}">
                                    <input type="hidden" name="markStore[{{$record->id}}][section]" value="{{$record->student_id}}">
                                    <input type="hidden" name="markStore[{{$record->id}}][roll_no]" value="{{$record->roll_no}}">
                                    <input type="hidden" name="markStore[{{$record->id}}][adimission_no]" value="{{$record->studentDetail->admission_no}}">
                                    {{$record->studentDetail->admission_no}}
                                </td>
                                <td>{{$record->roll_no}}</td>
                                <td>{{$record->class->class_name.'('.$record->section->section_name .')' }}</td>
                                <td>{{$record->studentDetail->full_name}}</td>
                                @php $entry_form_count=0; @endphp
                                @foreach($marks_entry_form as $part)
                            
                                @php $d = 5 + rand()%5;   @endphp
                                <td>
                                    <div class="input-effect mt-10">
                                    <input type="hidden" name="exam_setup_ids[]" value="{{$part->id}}">
                                    <?php 
                                    $search_mark = App\SmMarkStore::get_mark_by_part($record->student_id, $part->exam_term_id, $part->class_id, $part->section_id, $part->subject_id, $part->id); 
                                    ?>
                                        <input oninput="numberCheckWithDot(this)" class="primary-input marks_input" type="text" step="any" max="{{@$part->exam_mark}}"
                                        name="markStore[{{$record->id}}][marks][{{$part->subject_id}}]" value="{{!empty($search_mark)?$search_mark:0}}" {{@$absent_check->attendance_type == 'A' || @$absent_check->attendance_type == ''? 'readonly':''}}>
                                        
                                        <input class="primary-input" type="hidden" name="markStore[{{$record->id}}][exam_Sids][{{$entry_form_count++}}]" value="{{$part->id}}">
                                        
                                        <input type="hidden" id="part_marks" name="part_marks" value="{{$part->exam_mark}}">
                                        
                                        <label>{{$part->exam_title}} Mark</label>
                                        <span class="focus-border"></span>
                                    </div>                                
                                </td>
                                @endforeach
                                <?php 
                                $teacher_remarks = App\SmMarkStore::teacher_remarks($record->student_id, $exam_id, $record->class_id, $record->section_id, $subject_id); 
                                ?>
                                <td>
                                   
                                    <div class="input-effect mt-10">
                                    <input class="primary-input" type="text" name="markStore[{{$record->id}}][teacher_remarks][{{$part->subject_id}}]" value="{{$teacher_remarks}}" {{@$absent_check->attendance_type == 'A' || @$absent_check->attendance_type == ''? 'readonly':''}} >
                                    <label>@lang('teacher') @lang('remarks')</label>
                                    <span class="focus-border"></span>
                                </div>
                                </td>

                                <?php $is_absent_check = App\SmMarkStore::is_absent_check($record->student_id, $part->exam_term_id, $part->class_id, $part->section_id, $part->subject_id); ?>

                                <td>
                                    <div class="input-effect">
                                        @if(@$absent_check->attendance_type == 'P')
                                        <button class="primary-btn small fix-gr-bg" type="button">@lang('exam.present')</button>
                                        @else
                                        <button class="primary-btn small bg-danger text-white border-0" type="button">@lang('exam.absent')</button>
                                        @endif                              


                                        @if(@$absent_check->attendance_type == 'A')
                                        <input type="hidden" name="absent_students[]" value="{{$record->student_id}}">
                                        @endif
                                    </div>
                                        
                                </td>

                            </tr>
                            @endforeach 
                            @if(userPermission(224))
                            <tr>
                                <td colspan="{{count($marks_entry_form) + 5}}" class="text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg mt-20 submit">
                                        <span class="ti-check"></span>
                                        @lang('exam.save_marks')
                                    </button>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                
            
                </div>
            </div>
        </div>
    @endif
</section>
@endsection
