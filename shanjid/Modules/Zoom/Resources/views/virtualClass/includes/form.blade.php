@if (userPermission(556))
<div class="col-lg-3">

    <div class="main-title">
        <h3 class="mb-30">
            @if(isset($editdata))
                @lang('lang.edit')
            @else
                @lang('lang.add')
            @endif
            @lang('lang.virtual_class')
        </h3>
    </div>

    @if(isset($editdata))
        <form class="form-horizontal" action="{{ route('zoom.virtual-class.update',$editdata->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @method('') --}}
    @else
        @if(userPermission(561))
            <form class="form-horizontal" action="{{ route('zoom.virtual-class.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        @endif
    @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <select class="w-100 bb niceSelect form-control {{ @$errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                    <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class') *</option>
                                    @foreach($classes as $class)
                                        @if (isset($editdata))
                                            <option value="{{ @$class->id}}" {{ old('class',$editdata->class_id)  ? 'selected':''}}>{{ @$class->class_name }}</option>
                                        @else
                                            <option value="{{ @$class->id}}" {{ old('class')  ? 'selected':''}}>{{ @$class->class_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- <input type="hidden" name="id" value="{{isset($assign_class_teacher)? $assign_class_teacher->id: ''}}"> --}}

                        <div class="row  mt-40">

                            {{-- <div class="col-lg-12" id="selectSectionsDiv">
                                <label for="checkbox" class="mb-2">@lang('lang.section')</label>
                               <select multiple id="selectSectionss" name="section[]" style="width:300px">
                                 
                               </select>
                               <div class="">
                                   <input type="checkbox" id="checkbox_section" class="common-checkbox">
                                   <label for="checkbox_section" class="mt-3">@lang('lang.select_all')</label>
                               </div>
                               @if ($errors->has('section'))
                                   <span class="invalid-feedback invalid-select" role="alert">
                                       <strong>{{ $errors->first('section') }}</strong>
                                   </span>
                               @endif
                        </div> --}}
                            <div class="col-lg-12" id="select_section_div">                                
                                <select class="w-100 bb niceSelect form-control {{ @$errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                    <option data-display="@lang('lang.select_section')" value="">@lang('lang.select_section') </option>
                                    @if(isset($editdata))
                                        @foreach($class_sections as $section)
                                            <option value="{{ @$section->id }}" {{ old('section',$section->id) == $editdata->section_id ? 'selected':''}}>{{ @$section->section_name}} </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('section'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('section') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if(Auth::user()->role_id == 1 )
                        <div class="row mt-40">
                            <div class="col-lg-12" id="selectTeacherDiv">
                                <label for="teacher_ids" class="mb-2">@lang('lang.teacher') *</label>
                                        @foreach($teachers as $teacher)
                                            <div class="">
                                                @if(isset($editdata))
                                                    <input type="checkbox" id="section{{@$teacher->user_id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('teacher_ids') ? ' is-invalid' : '' }}"
                                                           name="teacher_ids[]"
                                                           value="{{@$teacher->user_id}}" {{ $editdata->teachers->contains($teacher->user_id) ? 'checked': ''}}>
                                                    <label for="section{{@$teacher->user_id}}">{{@$teacher->full_name }}</label>
                                                @else
                                                    <input type="radio" id="section{{@$teacher->user_id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('teacher_ids') ? ' is-invalid' : '' }}"
                                                           name="teacher_ids" value="{{@$teacher->user_id}}">
                                                    <label for="section{{@$teacher->user_id}}"> {{@$teacher->full_name}}</label>
                                                @endif
                                            </div>


                                        @endforeach
                                    @if ($errors->has('teacher_ids'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('teacher_ids') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        @endif
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('topic') ? ' is-invalid' : '' }}"
                                    type="text" name="topic" autocomplete="off" value="{{ isset($editdata) ?  old('topic',$editdata->topic) : old('topic') }}">
                                    <label>@lang('lang.topic')<span>*</span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('topic'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('topic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="4" name="description" id="address">{{isset($editdata) ? old('description',$editdata->description) : old('description')}}</textarea>
                                    <label>@lang('lang.description')</label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-6">
                                <label>@lang('lang.date_of_class')<span>*</span></label>
                                <input class="primary-input date form-control" id="startDate" type="text" name="date" readonly="true" value="{{ isset($editdata) ? old('date',Carbon\Carbon::parse($editdata->date_of_meeting)->format('m/d/Y')): old('date',Carbon\Carbon::now()->format('m/d/Y'))}}" required>
                                @if ($errors->has('date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                    <label>@lang('lang.time_of_class')<span>*</span></label>
                                    <input class="primary-input time form-control{{ @$errors->has('time') ? ' is-invalid' : '' }}" type="text" name="time" value="{{ isset($editdata) ? old('time',$editdata->time_of_meeting): old('time')}}">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ @$errors->first('time') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input oninput="numberCheck(this)" type="number" class="primary-input form-control{{ $errors->has('durration') ? ' is-invalid' : '' }}"
                                    type="text" name="durration" autocomplete="off" value="{{isset($editdata)? old('durration',$editdata->meeting_duration) : old('durration')}}">
                                    <label>@lang('lang.duration_of_class')<span>*</span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('durration'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('durration') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input oninput="numberCheck(this)" type="number" class="primary-input form-control{{ $errors->has('time_before_start') ? ' is-invalid' : '' }}"
                                    type="text" name="time_before_start" autocomplete="off" value="{{isset($editdata)? old('time_before_start',$editdata->time_before_start) : 10 }}">
                                    <label>@lang('lang.class') @lang('lang.start') @lang('lang.before')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('time_before_start'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('time_before_start') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    type="text" name="password" autocomplete="off" value="{{ isset($editdata) ?  old('password',$editdata->password) : old('password',123456) }}">
                                    <label>@lang('lang.password')<span>*</span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    <div class="row mt-30">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.zoom_recurring')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30">
                                        <input type="radio" name="is_recurring" id="recurring_options1" value="1" class="common-radio recurring-type" {{old('is_recurring',$editdata->is_recurring) == 1? 'checked': ''}}>
                                    <label for="recurring_options1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30">
                                        <input type="radio" name="is_recurring" id="recurring_options2" value="0" class="common-radio recurring-type" {{old('is_recurring',$editdata->is_recurring) == 0? 'checked': ''}}>
                                        <label for="recurring_options2">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30">
                                        <input type="radio" name="is_recurring" id="recurring_options1" value="1" class="common-radio recurring-type" {{old('is_recurring') == 1? 'checked': ''}}>
                                        <label for="recurring_options1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30">
                                        <input type="radio" name="is_recurring" id="recurring_options2" value="0" class="common-radio recurring-type" {{old('is_recurring') == 0? 'checked': ''}}>
                                        <label for="recurring_options2">@lang('lang.no')</label>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="row mt-20 recurrence-section-hide">
                        <div class="col-lg-6">
                            {{-- <label>Recurrence Type *</label> --}}
                            <select class="w-100 bb niceSelect form-control {{ @$errors->has('recurring_type') ? ' is-invalid' : '' }}" id="recurring_type" name="recurring_type">
                                <option data-display="@lang('lang.type') *" value="">@lang('lang.type') *</option>
                                @if (isset($editdata))
                                    <option value="1" {{ old('recurring_type',$editdata->recurring_type) == 1  ? 'selected':''}} >@lang('lang.zoom_recurring_daily')</option>
                                    <option value="2" {{ old('recurring_type',$editdata->recurring_type) == 2  ? 'selected':''}} >@lang('lang.zoom_recurring_weekly')</option>
                                    <option value="3" {{ old('recurring_type',$editdata->recurring_type) == 3  ? 'selected':''}}>@lang('lang.zoom_recurring_monthly') </option>
                                @else
                                    <option value="1" {{ old('recurring_type') == 1  ? 'selected':''}} > @lang('lang.zoom_recurring_daily')</option>
                                    <option value="2" {{ old('recurring_type') == 2  ? 'selected':''}} > @lang('lang.zoom_recurring_weekly')</option>
                                    <option value="3" {{ old('recurring_type') == 3  ? 'selected':''}}>  @lang('lang.zoom_recurring_monthly') </option>
                                @endif
                            </select>
                            @if ($errors->has('recurring_type'))
                            <span class="invalid-feedback invalid-select" role="alert">
                                <strong>{{ @$errors->first('recurring_type') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                                {{-- <label>Repeat every *</label> --}}
                                <select class="w-100 bb niceSelect form-control {{ @$errors->has('recurring_repect_day') ? ' is-invalid' : '' }}" id="recurring_repect_day" name="recurring_repect_day">
                                        <option data-display="@lang('lang.select') *" value="">@lang('lang.zoom_recurring_repect') *</option>
                                    @for ($i = 1; $i <= 15; $i++)
                                        @if (isset($editdata))
                                            <option value="{{ $i }}" {{ old('recurring_repect_day',$editdata->recurring_repect_day) == $i ? 'selected':''}} >{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}" {{ old('recurring_repect_day') == $i ? 'selected':''}}  >{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                                @if ($errors->has('recurring_repect_day'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('recurring_repect_day') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    {{-- <div class="row mt-30 day_hide" id="day_hide">
                        <div class="col-lg-12">
                            <label>@lang('lang.occurs_on') *</label>
                            @foreach($days as $day)
                                        <div class="row">
                                            <div class="col-md-4">
                                                @if(isset($editdata))
                                                    <input type="checkbox" id="day{{@$day->id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                           name="days[]"
                                                           value="{{@$day->id}}"{{in_array($day->order,$assign_day ?? '')? 'checked':''}} >
                                                    <label for="day{{@$day->id}}">{{@$day->name }}</label>
                                                @else
                                                    <input type="checkbox" id="day{{@$day->id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                           name="days[]" value="{{@$day->order}}">
                                                    <label for="day{{@$day->id}}"> {{@$day->name}}</label>
                                                @endif
                                            </div>

                                        </div>
                                        @endforeach
                                    @if ($errors->has('days'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('days') }}</strong>
                                        </span>
                                    @endif
                        </div>
                    </div> --}}

                    
                    <div class="row mt-30 day_hide" id="day_hide">
                        <div class="col-lg-12 ml-15">
                            <label>@lang('lang.occurs_on') *</label>
                            @foreach($days as $day)
                                        <div class="row ml-15">
                                            <div class="">
                                                @if(isset($editdata))
                                                    <input type="checkbox" id="day{{@$day->id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                           name="days[]"
                                                           value="{{@$day->zoom_order}}"{{in_array($day->zoom_order,$assign_day ?? '')? 'checked':''}} >
                                                    <label for="day{{@$day->id}}">{{@$day->name }}</label>
                                                @else
                                                    <input type="checkbox" id="day{{@$day->id}}"
                                                           class="common-checkbox form-control{{ @$errors->has('days') ? ' is-invalid' : '' }}"
                                                           name="days[]" value="{{@$day->zoom_order}}">
                                                    <label for="day{{@$day->id}}"> {{@$day->name}}</label>
                                                @endif
                                            </div>

                                        </div>
                                        @endforeach
                                    @if ($errors->has('days'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('days') }}</strong>
                                        </span>
                                    @endif
                        </div>
                    </div>

                    <div class="row mt-30 recurrence-section-hide">
                        <div class="col-lg-6">
                            <label>@lang('lang.zoom_recurring_end') *</label>
                            <input class="primary-input date form-control" sty id="recurring_end_date" type="text" name="recurring_end_date" readonly="true" value="{{ isset($editdata) ? old('recurring_end_date',Carbon\Carbon::parse($editdata->recurring_end_date)->format('m/d/Y')): old('recurring_end_date')}}" required>
                            @if ($errors->has('recurring_end_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('recurring_end_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row no-gutters input-right-icon mt-30">
                        <div class="col">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control {{ $errors->has('attached_file') ? ' is-invalid' : '' }}"
                                    readonly="true" type="text"
                                    placeholder="{{isset($editdata->attached_file) && @$editdata->attached_file != ""? getFilePath3(@$editdata->attached_file) : 'Attach File'}}"
                                    id="placeholderUploadContent">
                                <span class="focus-border"></span>
                                @if ($errors->has('attached_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('attached_file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg"
                                    for="upload_content_file">@lang('lang.browse')</label>
                                <input type="file" class="d-none form-control" name="attached_file"
                                    id="upload_content_file">
                            </button>
                        </div>
                    </div>

                    {{-- Start setting  --}}
                    <div class="row mt-40">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.change_default_settings')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                    <div class="mr-30 row">
                                        <input type="radio" name="chnage-default-settings" id="change_default_settings" value="1" @if (isset($editdata)) checked @endif class="common-radio chnage-default-settings relationButton">
                                        <label for="change_default_settings">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="chnage-default-settings" id="change_default_settings2" value="0" @if (!isset($editdata)) checked @endif class="common-radio chnage-default-settings relationButton">
                                        <label for="change_default_settings2">@lang('lang.no')</label>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-40 default-settings">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.join_before_host')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30 row">
                                        <input type="radio" name="join_before_host" id="metting_options1" value="1" class="common-radio relationButton" {{ old('join_before_host',$editdata->join_before_host) == 1 ? 'checked': ''}}>
                                        <label for="metting_options1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="join_before_host" id="metting_options2" value="0" class="common-radio relationButton" {{ old('join_before_host',$editdata->join_before_host) == 0 ? 'checked': ''}}>
                                        <label for="metting_options2">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30 row">
                                        <input type="radio" name="join_before_host" id="metting_options1" value="1" class="common-radio relationButton" {{ old('join_before_host', $default_settings->join_before_host) == 1? 'checked': ''}}>
                                        <label for="metting_options1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="join_before_host" id="metting_options2" value="0" class="common-radio relationButton" {{ old('join_before_host', $default_settings->join_before_host) == 0? 'checked': ''}}>
                                        <label for="metting_options2">@lang('lang.no')</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.host_video')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30 row">
                                        <input type="radio" name="host_video" id="host_video1" value="1" class="common-radio relationButton" {{old('host_video',$editdata->host_video) == 1? 'checked': ''}}>
                                        <label for="host_video1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="host_video" id="host_video2" value="0" class="common-radio relationButton" {{old('host_video',$editdata->host_video) == 0? 'checked': ''}}>
                                        <label for="host_video2">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30 row">
                                        <input type="radio" name="host_video" id="host_video1" value="1" class="common-radio relationButton" {{old('host_video',$default_settings->host_video) == 1? 'checked': ''}}>
                                        <label for="host_video1">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="host_video" id="host_video2" value="0" class="common-radio relationButton" {{old('host_video',$default_settings->host_video) == 0? 'checked': ''}}>
                                        <label for="host_video2">@lang('lang.no')</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.participant_video')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30 row">
                                        <input type="radio" name="participant_video" id="host_video3" value="1" class="common-radio" {{old('participant_video', $editdata->participant_video) == 1 ? 'checked': ''}}>
                                        <label for="host_video3">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="participant_video" id="host_video4" value="0" class="common-radio" {{old('participant_video', $editdata->participant_video) == 0 ? 'checked': ''}}>
                                        <label for="host_video4">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30 row">
                                        <input type="radio" name="participant_video" id="host_video3" value="1" class="common-radio" {{ old('participant_video', $default_settings->participant_video) == 1 ? 'checked': ''}}>
                                        <label for="host_video3">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="participant_video" id="host_video4" value="0" class="common-radio" {{ old('participant_video', $default_settings->participant_video) == 0 ? 'checked': ''}}>
                                        <label for="host_video4">@lang('lang.no')</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.mute_upon_entry') </p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30 row">
                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entry_on" value="1" class="common-radio" {{old('mute_upon_entry', $editdata->mute_upon_entry) == 1 ? 'checked': ''}}>
                                        <label for="mute_upon_entry_on">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entry" value="0" class="common-radio" {{old('mute_upon_entry', $editdata->mute_upon_entry) == 0 ? 'checked': ''}}>
                                        <label for="mute_upon_entry">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30 row">
                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entry_on" value="1" class="common-radio" {{ old('mute_upon_entry', $default_settings->mute_upon_entry) == 1 ? 'checked': ''}}>
                                        <label for="mute_upon_entry_on">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entry" value="0" class="common-radio" {{ old('mute_upon_entry', $default_settings->mute_upon_entry) == 0 ? 'checked': ''}}>
                                        <label for="mute_upon_entry">@lang('lang.no')</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 d-flex">
                            <p class="text-uppercase fw-500 mb-10" style="width: 130px;">@lang('lang.waiting_room')</p>
                            <div class="d-flex radio-btn-flex ml-40">
                                @if (isset($editdata))
                                    <div class="mr-30 row">
                                        <input type="radio" name="waiting_room" id="waiting_room_on" value="1" class="common-radio" {{old('waiting_room', $editdata->waiting_room) == 1 ? 'checked': ''}}>
                                        <label for="waiting_room_on">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="waiting_room" id="waiting_room" value="0" class="common-radio" {{old('waiting_room', $editdata->waiting_room) == 0 ? 'checked': ''}}>
                                        <label for="waiting_room">@lang('lang.no')</label>
                                    </div>
                                @else
                                    <div class="mr-30 row">
                                        <input type="radio" name="waiting_room" id="waiting_room_on" value="1" class="common-radio" {{ old('waiting_room', $default_settings->waiting_room) == 1 ? 'checked': ''}}>
                                        <label for="waiting_room_on">@lang('lang.yes')</label>
                                    </div>
                                    <div class="mr-30 row">
                                        <input type="radio" name="waiting_room" id="waiting_room" value="0" class="common-radio" {{ old('waiting_room', $default_settings->waiting_room) == 0 ? 'checked': ''}}>
                                        <label for="waiting_room">@lang('lang.no')</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($default_settings->package_id != 1 )
                        <div class="row mt-30 default-settings">
                            <div class="col-lg-12 row">
                                <p class="text-uppercase fw-500 mb-10 col-lg-6" style="width: 130px;">@lang('lang.auto_recording')</p>
                                <div class="col-lg-6">
                                    <select class="w-100 bb niceSelect form-control {{ @$errors->has('auto_recording') ? ' is-invalid' : '' }}" name="auto_recording">
                                        @if (isset($editdata))
                                            <option value="none" {{ old('auto_recording',$editdata->auto_recording) == 'none'? 'selected' : ''}} >@lang('lang.none')</option>
                                            <option value="local" {{ old('auto_recording',$editdata->auto_recording) == 'local'? 'selected' : ''}} >@lang('lang.local')</option>
                                            <option value="cloud" {{ old('auto_recording',$editdata->auto_recording) == 'cloud'? 'selected' : ''}} >@lang('lang.cloud')</option>
                                        @else
                                            <option value="none" {{ old('auto_recording',$default_settings->auto_recording) == 'none'? 'selected' : ''}} >@lang('lang.none')</option>
                                            <option value="local" {{ old('auto_recording',$default_settings->auto_recording) == 'local'? 'selected' : ''}} >@lang('lang.local')</option>
                                            <option value="cloud" {{ old('auto_recording',$default_settings->auto_recording) == 'cloud'? 'selected' : ''}} >@lang('lang.cloud')</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('auto_recording'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ @$errors->first('auto_recording') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 row">
                            <p class="text-uppercase fw-500 mb-10 col-lg-6" style="width: 130px;">@lang('lang.audio_options')</p>
                            <div class="col-lg-6">
                                <select class="w-100 bb niceSelect form-control {{ @$errors->has('audio') ? ' is-invalid' : '' }}" name="audio">
                                    <option data-display="@lang('lang.select') @lang('lang.package') *" value="">@lang('lang.select') @lang('lang.package') *</option>
                                    @if (isset($editdata))
                                        <option value="both" {{ old('audio',$editdata->audio) == 'both' ? 'selected' : ''}} >@lang('lang.both')</option>
                                        <option value="telephony"  {{ old('audio',$editdata->audio) == 'telephony'? 'selected' : ''}}>@lang('lang.telephony')</option>
                                        <option value="voip"  {{ old('audio',$editdata->audio) == 'voip'? 'selected' : ''}} >@lang('lang.voip')</option>
                                    @else
                                        <option value="both" {{ old('audio',$default_settings->audio) == 'both' ? 'selected' : ''}} >@lang('lang.both')</option>
                                        <option value="telephony"  {{ old('audio',$default_settings->audio) == 'telephony'? 'selected' : ''}}>@lang('lang.telephony')</option>
                                        <option value="voip"  {{ old('audio',$default_settings->audio) == 'voip'? 'selected' : ''}} >@lang('lang.voip')</option>
                                    @endif

                                </select>
                                @if ($errors->has('audio'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('audio') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-30 default-settings">
                        <div class="col-lg-12 row">
                            <p class="text-uppercase fw-500 mb-10 col-lg-6" style="width: 130px;">@lang('lang.meeting_approval')</p>
                            <div class="col-lg-6">
                                <select class="w-100 bb niceSelect form-control {{ @$errors->has('approval_type') ? ' is-invalid' : '' }}" name="approval_type">
                                    @if (isset($editdata))
                                        <option data-display="@lang('lang.select') @lang('lang.package') *" value="">@lang('lang.select') @lang('lang.package') *</option>
                                        <option value="0" {{ old('approval_type',$editdata->approval_type) == 0? 'selected' : ''}} >@lang('lang.automatically')</option>
                                        <option value="1" {{ old('approval_type',$editdata->approval_type) == 1? 'selected' : ''}} >@lang('lang.manually') @lang('lang.approve')</option>
                                        <option value="2" {{ old('approval_type',$editdata->approval_type) == 2? 'selected' : ''}} >@lang('lang.no') @lang('lang.registration') @lang('lang.required')</option>
                                    @else
                                        <option data-display="@lang('lang.select') @lang('lang.package') *" value="">@lang('lang.select') @lang('lang.package') *</option>
                                        <option value="0" {{ old('approval_type',$default_settings->approval_type) == 0? 'selected' : ''}} >@lang('lang.automatically')</option>
                                        <option value="1" {{ old('approval_type',$default_settings->approval_type) == 1? 'selected' : ''}} >@lang('lang.manually') @lang('lang.approve')</option>
                                        <option value="2" {{ old('approval_type',$default_settings->approval_type) == 2? 'selected' : ''}} >@lang('lang.no') @lang('lang.registration') @lang('lang.required')</option>
                                    @endif

                                </select>
                                @if ($errors->has('approval_type'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ @$errors->first('approval_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- End setting  --}}
                    @php
                    $tooltip = "";
                        if(userPermission(561) )
                        {
                            $tooltip = "";
                        }else{
                            $tooltip = "You have no permission to add";
                        }
                    @endphp
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                <span class="ti-check"></span>
                                @if(isset($editdata))
                                    @lang('lang.update')
                                @else
                                    @lang('lang.save')
                                @endif
                                @lang('lang.virtual_class')

                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@endif
