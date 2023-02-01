
<script>
    if ($(".niceSelectModal").length) {
        $(".niceSelectModal").niceSelect();
    }
</script>
<style type="text/css">
    .paddingTop86{
        padding-top: 88px;
    }
</style>
<div class="container-fluid">
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'add-new-lesson-plan',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'myForm', 'onsubmit' => "return validateLssonPlan()"]) }}
        <div class="row">
            <div class="col-lg-12">  
                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                <input type="hidden" name="day" id="day" value="{{@$day}}">              
                <input type="hidden" name="class_id"   id="class_id" value="{{@$class_id}}">
                <input type="hidden" name="section_id" id="section_id" value="{{@$section_id}}">
                <input type="hidden" name="subject_id" id="subject_id" value="{{@$subject_id}}">
                <input type="hidden" name="lesson_date"  id="lesson_date" value="{{$lesson_date}}">
                <input type="hidden" name="routine_id"  id="routine_id" value="{{$routine_id}}">
                <input type="hidden" name="teacher_id" id="update_teacher_id" value="{{isset($teacher_id)? $teacher_id:''}}">
                         

                <div class="row mt-25">

                    <div class="col-lg-4" >
                       <select class="w-100 bb niceSelect niceSelectModal form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_lesson" id="select_lesson" onchange="changeLesson()" name="lesson">
                        <option data-display="@lang('lesson::lesson.select_lesson')*" value="">@lang('lesson::lesson.select_lesson') *</option>
                        @foreach($lessons as $lesson)                        
                        <option value="{{ @$lesson->id}}" >{{ @$lesson->lesson_title}}</option>                      
                        @endforeach      
                    </select>
                         <span class="text-danger" role="alert" id="lesson_error"></span>

                    </div>
                    <div class="col-lg-4" id="select_topic_div">

                        <select class="w-100 bb niceSelect niceSelectModal form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_topic" id="select_topic" name="topic">
                            <option data-display="@lang('lesson::lesson.select_topic') *" value="">@lang('lesson::lesson.select_topic') *</option>
                        </select>
                        <div class="pull-right loader" id="select_topic_loader" style="margin-top: -30px;padding-right: 21px;">
                            <img src="{{asset('Modules/Lesson/Resources/assets/images/pre-loader.gif')}}" alt="" style="width: 28px;height:28px;">
                        </div> 
                               <span class="text-danger" role="alert" id="topic_error"></span>
    
                        </div>
                        <div class="col-lg-4 mt-30-md">
                            <div class="input-effect">
                                <input name="sub_topic"  class="primary-input form-control" type="text" >
                                <span class="focus-border"></span>
                                <label id="teacher_label">@lang('lesson::lesson.sub_topic')</label>
                               <span class="text-danger" role="alert" id="teacher_error">
                               </span>
                         </div>                        
                        </div>
                </div>

                <div class="row mt-25">
                    <div class="col-lg-6 mt-30-md">                       
                       
                          <textarea name="youtube_link" id="" cols="50" rows="6" class="primary-input form-control"></textarea>
                        
                         <label id="teacher_label" class="top20">@lang('lesson::lesson.lecture_youTube_url_multiple_url_separate_by_coma')</label>
                      
                                             
                    </div>

                     <div class="col-lg-6">
                        <div class="row no-gutters input-right-icon paddingTop86">
                            <div class="col">
                                <div class="input-effect">
                                    <input class="primary-input" id="placeholderInput" type="text"
                                           placeholder="{{ __('common.file') }}"
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
                                    <input type="file" class="d-none" id="browseFile" name="photo">
                                </button>
                            </div>
                         </div>
                    </div>                     
                    </div>
                </div>
                <div class="row mt-25">
                    <div class="col-lg-6 mt-30-md">
                        <div class="input-effect">
                        <label id="teacher_label">@lang('lesson::lesson.teaching_method')</label>
                         <textarea name="teaching_method" class="primary-input form-control" id="" cols="50"  rows="2"></textarea>
                     </div>                        
                    </div>
                    <div class="col-lg-6 mt-30-md">
                        <div class="input-effect">
                        <label id="teacher_label">@lang('lesson::lesson.general_objectives')</label>
                        <textarea name="general_Objectives" id="" cols="50" rows="2" class="primary-input form-control"></textarea>
                     </div>                        
                    </div>
                </div>
                <div class="row mt-25">
                    <div class="col-lg-6 mt-30-md">
                        <div class="input-effect">
                        <label id="teacher_label">@lang('lesson::lesson.previous_knowledge')</label>
                         <textarea name="previous_knowledge" id="" cols="50" rows="2" class="primary-input form-control"></textarea>
                     </div>                        
                    </div>
                    <div class="col-lg-6 mt-30-md">
                        <div class="input-effect">
                        <label id="teacher_label">@lang('lesson::lesson.comprehensive_questions')</label>
                        <textarea name="comprehensive_Questions" id="" cols="50" rows="2" class="primary-input form-control"></textarea>
                     </div>                        
                    </div>
                </div>
                <div class="row mt-25">
                    <div class="col-lg-12 mt-30-md">
                        <div class="input-effect">
                        <label id="teacher_label">@lang('common.note')</label>
                         <textarea name="note" id="" cols="50" rows="2" class="primary-input form-control"></textarea>
                     </div>                        
                    </div>
                    
                </div>

             


            </div>
            
            <div class="col-lg-12 text-center mt-40">
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('lesson::lesson.save_information')</button>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>



<script type="text/javascript">
    var fileInput = document.getElementById("browseFile");
    if (fileInput) {
        fileInput.addEventListener("change", showFileName);
        function showFileName(event) {
            var fileInput = event.srcElement;
            var fileName = fileInput.files[0].name;
            document.getElementById("placeholderInput").placeholder = fileName;
        }
    }
    var fileInp = document.getElementById("browseFil");
    if (fileInp) {
        fileInp.addEventListener("change", showFileName);
        function showFileName(event) {
            var fileInp = event.srcElement;
            var fileName = fileInp.files[0].name;
            document.getElementById("placeholderIn").placeholder = fileName;
        }
    }
</script>
