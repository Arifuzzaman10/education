
{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admission_query_update', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'admission-query-store']) }}
<input type="hidden" name="id" value="{{@$admission_query->id}}">
<div class="modal-body" id="editAdmissionQuery">
    <div class="container-fluid">
        <form action="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-effect">
                                <input class="primary-input read-only-input form-control" type="text" name="name"
                                       id="name" value="{{@$admission_query->name}}" required>
                                <label>@lang('common.name') <span>*</span></label>
                                <span class="text-danger" role="alert" id="nameError">
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-effect">
                                <input oninput="phoneCheck(this)" class="primary-input read-only-input form-control" type="text" name="phone"
                                       id="phone" value="{{@$admission_query->phone}}">
                                <label>@lang('common.phone')</label>
                                </span>
                                <span class="focus-border"></span>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-effect">
                                <input oninput="emailCheck(this)" class="primary-input read-only-input form-control" type="text" name="email"
                                       value="{{@$admission_query->email}}">
                                <label>@lang('common.email')</label>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-25">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <textarea class="primary-input form-control has-content" cols="0" rows="3" name="address"
                                          id="address">{{@$admission_query->address}}</textarea>
                                <label>@lang('common.address') <span></span> </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <textarea class="primary-input form-control has-content" cols="0" rows="3" name="description"
                                          id="description">{{@$admission_query->description}}</textarea>
                                <label>@lang('common.description') <span></span> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-25">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="input-effect">
                                        <input class="primary-input date form-control has-content" id="startDate" type="text"
                                               name="date" readonly="true"
                                               value="{{@$admission_query->date != ""? date('m/d/Y', strtotime(@$admission_query->date)) : date('m/d/Y')}}">
                                        <label>@lang('common.date')</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="start-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="input-effect">
                                        <input class="primary-input date form-control has-content" id="endDate" type="text"
                                               name="next_follow_up_date" autocomplete="off" readonly="true"
                                               value="{{@$admission_query->next_follow_up_date != ""? date('m/d/Y', strtotime(@$admission_query->next_follow_up_date)) : date('m/d/Y')}}">
                                        <label>@lang('academics.next_follow_up_date')</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="end-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-effect">
                                <input class="primary-input read-only-input form-control" type="text" name="assigned"
                                       value="{{@$admission_query->assigned}}" id="assigned" required>
                                <label>@lang('academics.assigned') <span></span></label>
                                <span class="text-danger" role="alert" id="assignedError"> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-25">
                    <div class="row">
                        <div class="col-lg-3">
                            <select class="niceSelect1 w-100 bb" name="reference" id="reference" required>
                                <option data-display="@lang('academics.reference')" value="">@lang('academics.reference')</option>
                                @foreach($references as $reference)
                                    <option value="{{@$reference->id}}" {{@$reference->id == @$admission_query->reference? 'selected':''}}>{{@$reference->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert" id="referenceError"></span>
                        </div>
                        <div class="col-lg-3">
                            <select class="niceSelect1 w-100 bb" name="source" id="source" required>
                                <option data-display="@lang('academics.source') *" value="">@lang('academics.source') *</option>
                                @foreach($sources as $source)
                                    <option value="{{@$source->id}}" {{@$source->id == @$admission_query->source? 'selected':''}}>{{@$source->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert" id="sourceError">                                
                            </span>
                        </div>
                        @if(moduleStatusCheck('University')==false)
                        <div class="col-lg-3">
                            <select class="niceSelect1 w-100 bb" name="class" id="class" id="class" required>
                                <option data-display="@lang('common.class')" value="">@lang('common.class')</option>
                                @foreach($classes as $class)
                                    <option value="{{@$class->id}}" {{@$class->id == @$admission_query->class? 'selected':''}}>{{@$class->class_name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert" id="classError"></span>
                        </div>
                        @endif
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input oninput="numberCheck(this)" class="primary-input form-control has-content" type="text" name="no_of_child"
                                       value="{{@$admission_query->no_of_child}}" id="no_of_child" required>
                                <label>@lang('academics.number_of_child') <span></span></label>
                                <span class="text-danger" role="alert" id="no_of_childError"></span>
                            </div>
                        </div>
                    </div>
                </div>
                @if(moduleStatusCheck('University'))
                <div class="col-lg-12 mt-25">
                    <div class="row">
                        @if(moduleStatusCheck('University'))
                            @includeIf('university::common.session_faculty_depart_academic_semester_level',['div'=>'col-lg-4', 'niceSelect' => 'niceSelect1', 'rowMt'=>'mt-25', 'hide'=>['USUB'], 'required' => ['USN','UF', 'UD', 'UA', 'US', 'USL']])
                            <input type="hidden" name="un_academic_id" id="select_academic" value="{{getAcademicId()}}">
                        @endif 
                    </div>
                </div>
                @endif
                <div class="col-lg-12 text-center mt-40">
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">@lang('common.cancel')</button>
                        <button class="primary-btn fix-gr-bg submit" id="update_button_query"
                                type="submit">@lang('common.update')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
{{ Form::close() }}
<script>
    $("#search-icon").on("click", function() {
        $("#search").focus();
    });

    $("#start-date-icon").on("click", function() {
        $("#startDate").focus();
    });

    $("#end-date-icon").on("click", function() {
        $("#endDate").focus();
    });

    $(".primary-input.date").datepicker({
        autoclose: true,
        setDate: new Date(),
    });
    $(".primary-input.date").on("changeDate", function(ev) {
        // $(this).datepicker('hide');
        $(this).focus();
    });

    $(".primary-input.time").datetimepicker({
        format: "LT",
    });

    if ($(".niceSelect1").length) {
        $(".niceSelect1").niceSelect();
    }
</script>


<!-- End Sibling Add Modal -->
