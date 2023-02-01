<div class="col-12 mt-25">
    <div class="row">
        <div class="col-lg-{{generalSetting()->sub_topic_enable ? 5 : 10}} select_topic_div" id="select_topic_div">
            <select
                class="w-100 bb niceSelect niceSelectModal form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_topic"
                id="select_topic" name="topic[]">
                <option data-display="@lang('lesson::lesson.select_topic') *" value="">
                    @lang('lesson::lesson.select_topic') *</option>
                @foreach ($topics as $item)
                    <option value="{{ $item->id }}" @isset($lessonPlanDetail)
                        {{ $lessonPlanDetail->topic_detail_id == $topicData->id ? 'selected' : '' }}
                    @endisset >{{ $item->topic_title }} </option>

                @endforeach
            </select>
            <div class="pull-right loader" id="select_topic_loader" style="margin-top: -30px;padding-right: 21px;">
                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}" alt=""
                    style="width: 28px;height:28px;">
            </div>
            <span class="text-danger" role="alert" id="topic_error"></span>
        </div>
        @if(generalSetting()->sub_topic_enable)
        <div class="col-lg-5 mt-30-md">
            <div class="input-effect">
                <input name="sub_topic[]" class="primary-input read-only-input form-control" type="text">
                <span class="focus-border"></span>
                <label id="teacher_label">@lang('lesson::lesson.sub_topic')</label>
                <span class="text-danger" role="alert" id="teacher_error">
                </span>
            </div>
        </div>
        @endif
        <div class="col-2">
            <button class="removeTopiceRowBtn primary-btn icon-only fix-gr-bg" type="button">
                <span class="ti-trash"></span> </button>
        </div>
    </div>
</div>
