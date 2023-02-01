@extends('backEnd.master')

@section('title')
    @lang('admin.admission_query')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('admin.admission_query')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('admin.admin_section')</a>
                    <a href="#">@lang('admin.admission_query')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('admin.select_criteria')</h3>
                    </div>
                </div>
                <div class="col-lg-4 text-md-right col-md-6 mb-30-lg col-6 text-right ">
                    @if(userPermission(13))
                        <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button"
                                data-toggle="modal" data-target="#addQuery">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </button>
                    @endif
                </div>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admission-query-search', 'method' => 'POST', 'enctype' => 'multipart/form-data','id'=>'infix_form']) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input name="date_from" readonly
                                           class="primary-input date {{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{isset($date_from)? ($date_from != ""? $date_from:''):''}}">
                                    <label>@lang('admin.date_from') *</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_from'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('date_from') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input name="date_to" readonly
                                           class="primary-input date {{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{isset($date_to)? ($date_to != ""? $date_to:''):''}}">
                                    <label>@lang('admin.date_to') *</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_to'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('date_to') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select name="source"
                                            class="niceSelect w-100 bb form-control {{ $errors->has('select_source') ? ' is-invalid' : '' }}"
                                            required>
                                        <option data-display="@lang('admin.select_source') *"
                                                value="">@lang('admin.select_source') *
                                        </option>
                                        @foreach($sources as $source)
                                            <option value="{{@$source->id}}" {{isset($source_id)? ($source_id == $source->id? 'selected':''):''}}>{{@$source->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('select_source'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('select_source') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control {{ $errors->has('select_status') ? ' is-invalid' : '' }}"
                                            name="status">
                                        <option data-display="@lang('admin.select_status') *"
                                                value="">@lang('admin.Status') *
                                        </option>
                                        <option value="1" {{isset($status_id)? ($status_id ==  '1'? 'selected':''):''}}>@lang('admin.active')</option>
                                        <option value="2" {{isset($status_id)? ($status_id == '2'? 'selected':''):''}}>@lang('admin.inactive')</option>
                                    </select>
                                    @if ($errors->has('select_status'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('select_status') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg" id="btnsubmit">
                                    <span class="ti-search pr-2"></span>
                                    @lang('admin.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('admin.query_list')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.source')</th>
                                    <th>@lang('admin.query_date')</th>
                                    <th>@lang('admin.last_follow_up_date')</th>
                                    <th>@lang('admin.next_follow_up_date')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admission_queries as $key=>$admission_query)
                                    <tr>
                                        <td>{{@$key+1}}</td>
                                        <td>{{@$admission_query->name}}</td>
                                        <td>{{@$admission_query->phone}}</td>
                                        <td>{{@$admission_query->sourceSetup != ""? @$admission_query->sourceSetup->name:''}}</td>
                                        <td data-sort="{{strtotime(@$admission_query->date)}}">{{dateConvert(@$admission_query->date)}} </td>
                                        <td data-sort="{{strtotime(@$admission_query->follow_up_date)}}">
                                            {{@$admission_query->follow_up_date != ""? dateConvert(@$admission_query->follow_up_date):''}}
                                        </td>
                                        <td data-sort="{{strtotime(@$admission_query->next_follow_up_date)}}">
                                            {{@$admission_query->next_follow_up_date != ""? dateConvert(@$admission_query->next_follow_up_date):''}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    @lang('admin.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(userPermission(13))
                                                        <a class="dropdown-item"
                                                           href="{{route('add_query', [@$admission_query->id])}}">@lang('admin.add_query')</a>
                                                    @endif
                                                    @if(userPermission(14))
                                                        <a class="dropdown-item modalLink" data-modal-size="large-modal"
                                                           title="@lang('admin.edit_admission_query')"
                                                           href="{{route('admission_query_edit', [@$admission_query->id])}}">@lang('common.edit')</a>
                                                    @endif
                                                    @if(userPermission(15))
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                           data-target="#deleteAdmissionQueryModal{{@$admission_query->id}}">@lang('common.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade admin-query"
                                         id="deleteAdmissionQueryModal{{@$admission_query->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('admin.delete_admission_query')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        <h5 class="text-danger">( @lang('admin.delete_conformation')
                                                            )</h5>
                                                    </div>
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">@lang('admin.cancel')</button>
                                                        {{ Form::open(['route' => 'admission_query_delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                        <input type="hidden" name="id"
                                                               value="{{@$admission_query->id}}">
                                                        <button class="primary-btn fix-gr-bg"
                                                                type="submit">@lang('admin.delete')</button>
                                                        {{ Form::close() }}
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
    <!-- Start Sibling Add Modal -->
    <div class="modal fade admin-query" id="addQuery">
        <div class="modal-dialog max_modal modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('admin.admission_query')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admission_query_store_a', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'admission-query-store']) }}
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="input-effect">
                                                <input class="primary-input read-only-input form-control" type="text"
                                                       name="name" id="name">
                                                <label>@lang('admin.name')<span>*</span></label>
                                                <span class="text-danger" role="alert" id="nameError">

                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-effect">
                                                <input oninput="phoneCheck(this)" class="primary-input read-only-input form-control" type="text"
                                                       name="phone" id="phone" >
                                                <label>@lang('admin.phone')</label>
                                                <span class="focus-border"></span>
                                                <span class="text-danger" role="alert" id="phoneError">
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-effect">
                                                <input oninput="emailCheck(this)" class="primary-input read-only-input form-control" type="email"
                                                       name="email">
                                                <label>@lang('admin.email')<span></span></label>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-25">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-effect">
                                                <textarea class="primary-input form-control" cols="0" rows="3"
                                                          name="address" id="address"></textarea>
                                                <label>@lang('admin.address')<span></span> </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-effect">
                                                <textarea class="primary-input form-control" cols="0" rows="3"
                                                          name="description" id="description"></textarea>
                                                <label>@lang('admin.description')<span></span> </label>
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
                                                        <input class="primary-input date form-control" id="startDate"
                                                               type="text"
                                                               name="date" readonly="true" value="{{date('m/d/Y')}}"
                                                               required>
                                                        <label>@lang('admin.date') *</label>
                                                        {{-- <span class="text-danger">{{ $errors->has('date') ? $errors->first('date') : ' ' }}</span> --}}
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
                                                        <input class="primary-input date form-control" id="endDate"
                                                               type="text"
                                                               name="next_follow_up_date" autocomplete="off"
                                                               readonly="true" value="{{date('m/d/Y', strtotime(' + 1 days'))}}" required>
                                                        <label>@lang('admin.next_follow_up_date') *</label>
                                                        {{-- <span class="text-danger">{{ $errors->has('next_follow_up_date') ? $errors->first('next_follow_up_date') : ' ' }}</span> --}}
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
                                                <input class="primary-input read-only-input form-control" type="text"
                                                       name="assigned" id="assigned">
                                                <label>@lang('admin.assigned') *<span></span></label>
                                                <span class="text-danger" role="alert" id="assignedError"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-25">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select class="niceSelect w-100 bb" name="reference" id="reference">
                                                <option data-display="@lang('admin.reference') *"
                                                        value="">@lang('admin.reference') *
                                                </option>
                                                @foreach($references as $reference)
                                                    <option value="{{$reference->id}}">{{$reference->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" role="alert" id="referenceError"></span>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="niceSelect w-100 bb" name="source" id="source">
                                                <option data-display="@lang('admin.source') *" value="">@lang('admin.source')*</option>
                                                @foreach($sources as $source)
                                                    <option value="{{ @$source->id}}">{{ @$source->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" role="alert" id="sourceError"></span>
                                        </div>

                                        
                                        @if(moduleStatusCheck('University'))
                                            
                                        @else
                                        <div class="col-lg-3">
                                            <select class="niceSelect w-100 bb" name="class" id="class">
                                                <option data-display="@lang('common.class') *"
                                                        value="">@lang('common.class') *
                                                </option>
                                                @foreach($classes as $class)
                                                    <option value="{{@$class->id}}">{{ @$class->class_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" role="alert" id="classError"></span>
                                        </div>
                                        @endif

                                        <div class="col-lg-3">
                                            <div class="input-effect">
                                                <input oninput="numberMinCheck(this)" class="primary-input read-only-input form-control"
                                                       type="text" name="no_of_child" id="no_of_child">
                                                <label>@lang('admin.number_of_child') *<span></span></label>
                                                <span class="focus-border"></span>
                                                <span class="text-danger" role="alert" id="no_of_childError"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-25">
                                    <div class="row">
                                        @includeIf('university::common.session_faculty_depart_academic_semester_level',['mt' => 'mt-25', 'div' => 'col-lg-4',  'hide'=> ['USUB','UA'], 'required' => ['USN','UF', 'UD', 'US', 'USL']])
                                        <input type="hidden" name="un_academic_id" id="select_academic" value="{{getAcademicId()}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center mt-40">
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('admin.cancel')</button>
                                        <button class="primary-btn fix-gr-bg submit" id="save_button_query" type="submit">@lang('admin.save')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
    <!-- End Sibling Add Modal -->
@endsection
@section('script')
    <script>
        @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
        @endif
    </script>
@endsection
