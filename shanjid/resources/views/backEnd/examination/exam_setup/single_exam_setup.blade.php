{{-- single Exam Div  --}}

      <div class="row mt-25 mb-25">
          <div class="col-lg-12">
              <select class="w-100 bb niceSelect form-control {{ $errors->has('exams_type') ? ' is-invalid' : '' }}" id="exam_class" name="exams_type">
                  <option data-display="@lang('common.select_exam_type') *" value="">@lang('common.select_exam_type') *</option>
                  @foreach($exams_types as $exams_type)
                      <option value="{{@$exams_type->id}}">{{@$exams_type->title}}</option>
                  @endforeach
              </select>
              @if ($errors->has('exams_type'))
                  <span class="invalid-feedback invalid-select" role="alert">
                      <strong>{{ $errors->first('exams_type') }}</strong>
                  </span>
              @endif
          </div>
      </div>
      @if(moduleStatusCheck('University'))
      @includeIf('university::common.session_faculty_depart_academic_semester_level',
      ['required' => 
          ['USN', 'UD', 'UA', 'US', 'USL'],
          'div'=>'col-lg-12','row'=>1,'mt'=>'mt-0' ,'subject'=>true, 
      ])

      {{-- <label class="mt-30">@lang('university::un.select_subject') *</label>
      <div class="row" id="universityExamSubejct"></div>
          <div class="text-center loader loader_style" id="unSubjectLoader">
              <img src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader" height="60px" width="60px">
          </div> --}}
      @else 
      <div class="row mt-25">
          <div class="col-lg-12">
              <select class="w-100 bb niceSelect form-control {{ $errors->has('class_id') ? ' is-invalid' : '' }}" id="classSelectStudentHomeWork" name="class_id">
                  <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                  @foreach($classes as $class)
                  <option value="{{@$class->id}}">{{@$class->class_name}}</option>
                  @endforeach
              </select>
              @if ($errors->has('class_id'))
                  <span class="invalid-feedback invalid-select" role="alert">
                      <strong>{{ $errors->first('class_id') }}</strong>
                  </span>
              @endif
          </div>
      </div>
      <div class="row mt-25">
          <div class="col-lg-12">
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
      </div>
      <div class="row mt-25">
          <div class="col-lg-12 " id="selectSectionsDiv" style="margin-top: -25px;">
              <label for="checkbox" class="mb-2 mt-20">@lang('common.section') *</label>
                  <select multiple id="selectSectionss" name="section_ids[]" style="width:300px">
                    
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
      @endif

<script>
if ($(".niceSelect").length) {
      $(".niceSelect").niceSelect();
}
</script>


@if(moduleStatusCheck('University'))
<script src="{{ asset('Modules/University/Resources/assets/js/app.js') }}"></script>
@else 
<script src="{{ asset('public/backEnd/js/custom.js') }}"></script>
<script src="{{ asset('public/backEnd/js/developer.js') }}"></script>
@endif 


  {{-- single Exam End  --}}