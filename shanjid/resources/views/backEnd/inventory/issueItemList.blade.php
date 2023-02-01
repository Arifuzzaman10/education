@extends('backEnd.master')
@section('title')
    @lang('inventory.issue_item_list')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('inventory.issue_item_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('inventory.inventory')</a>
                    <a href="#">@lang('inventory.issue_item_list')</a>
                </div>
            </div>
        </div>
    </section>
    <style type="text/css">
        #selectStaffsDiv,
        .forStudentWrapper {
            display: none;
        }
    </style>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @lang('inventory.issue_a_item')
                                </h3>
                            </div>
                            @if (isset($editData))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['holiday-update', $editData->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission(346))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'save-item-issue-data',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">

                                        <div class="col-lg-12 mb-30">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                                name="role_id" id="member_type">
                                                <option data-display=" @lang('inventory.user_type') *" value="">@lang('inventory.user_type')
                                                    *</option>
                                                @foreach ($roles as $value)
                                                    @if (isset($editData))
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $editData->role_id ? 'selected' : '' }}>
                                                            {{ $value->name }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}"
                                                            {{ old('role_id') != '' ? (old('role_id') == $value->id ? 'selected' : '') : '' }}>
                                                            {{ $value->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="forStudentWrapper col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12 mb-30">
                                                    <select
                                                        class="w-100 bb niceSelect form-control{{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                        id="select_class" name="class">
                                                        <option data-display="@lang('common.select_class') *" value="">
                                                            @lang('common.select_class') *</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}"
                                                                {{ old('class') == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('class'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ $errors->first('class') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-12 mb-30" id="select_section_div">
                                                    <select
                                                        class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                        id="select_section" name="section">
                                                        <option data-display="@lang('common.select_section') *" value="">
                                                            @lang('common.select_section') *</option>
                                                    </select>
                                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                                        <img class="loader_img_style"
                                                            src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                                            alt="loader">
                                                    </div>
                                                    @if ($errors->has('section'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ $errors->first('section') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-12 mb-30" id="select_student_div">
                                                    <select
                                                        class="w-100 bb niceSelect form-control{{ $errors->has('student') ? ' is-invalid' : '' }}"
                                                        id="select_student" name="student">
                                                        <option data-display="@lang('common.select_student')*" value="">
                                                            @lang('inventory.select_student_for_issue') *</option>
                                                    </select>
                                                    <div class="pull-right loader loader_style" id="select_student_loader">
                                                        <img class="loader_img_style"
                                                            src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                                            alt="loader">
                                                    </div>
                                                    @if ($errors->has('student'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ $errors->first('student') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-30" id="selectStaffsDiv">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('staff_id') ? ' is-invalid' : '' }}"
                                                name="staff_id" id="selectStaffs">
                                                <option data-display="@lang('inventory.issue_to')" value="">@lang('inventory.issue_to')
                                                </option>

                                                @if (isset($staffsByRole))
                                                    @foreach ($staffsByRole as $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $editData->staff_id ? 'selected' : '' }}>
                                                            {{ $value->full_name }}</option>
                                                    @endforeach
                                                @else
                                                @endif
                                            </select>
                                            @if ($errors->has('staff_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('staff_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="row no-gutters input-right-icon mb-30 w-100">

                                        <div class="col">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input date form-control{{ $errors->has('issue_date') ? ' is-invalid' : '' }}"
                                                    id="startDate" type="text" name="issue_date"
                                                    value="{{ isset($editData) ? date('m/d/Y', strtotime($editData->issue_date)) : date('m/d/Y') }}">
                                                <label>@lang('inventory.issue_date') <span></span> </label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('issue_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('issue_date') }}</strong>
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

                                    <div class="row no-gutters input-right-icon mb-30 w-100">

                                        <div class="col">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input date form-control{{ $errors->has('due_date') ? ' is-invalid' : '' }}"
                                                    id="endDate" type="text" name="due_date"
                                                    value="{{ isset($editData) ? date('m/d/Y', strtotime($editData->issue_date)) : date('m/d/Y') }}">
                                                <label>@lang('inventory.return_date') <span></span> </label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('due_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('due_date') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="end-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 mb-30">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('item_category_id') ? ' is-invalid' : '' }}"
                                                name="item_category_id" id="item_category_id">
                                                <option data-display="@lang('inventory.item_category') *" value="">
                                                    @lang('inventory.item_category') *</option>
                                                @foreach ($itemCat as $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ old('item_category_id') == $value->id ? 'selected' : '' }}>
                                                        {{ $value->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('item_category_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('item_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-12 mb-30" id="selectItemsDiv">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('item_id') ? ' is-invalid' : '' }}"
                                                name="item_id" id="selectItems">
                                                <option data-display="@lang('inventory.item_name') *" value="">
                                                    @lang('inventory.item_name') *</option>
                                            </select>
                                            @if ($errors->has('item_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('item_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-12 mb-30">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                                    type="text" onkeypress="return isNumberKey(event)" name="quantity"
                                                    autocomplete="off" value="{{ old('quantity') }}">
                                                <label>@lang('inventory.quantity') <span>*</span> </label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('quantity'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('quantity') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-30">
                                            <div class="input-effect">
                                                <textarea class="primary-input form-control" cols="0" rows="4" name="description" id="description">{{ isset($editData) ? $editData->description : old('description') }}</textarea>
                                                <label>@lang('inventory.note') <span></span> </label>
                                                <span class="focus-border textarea"></span>

                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                                    @php
                                        $tooltip = '';
                                        if (userPermission(346)) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit issuedSubmit" data-toggle="tooltip"
                                                title="{{ $tooltip }}">

                                                <span class="ti-check"></span>
                                                @if (isset($editData))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.save')
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
                                <h3 class="mb-0"> @lang('inventory.issued_item_list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th> @lang('common.sl')</th>
                                        <th> @lang('inventory.item_name')</th>
                                        <th> @lang('inventory.item_category')</th>
                                        <th> @lang('inventory.issue_to')</th>
                                        <th> @lang('inventory.issue_date')</th>
                                        <th> @lang('inventory.return_date')</th>
                                        <th> @lang('inventory.quantity')</th>
                                        <th> @lang('common.status')</th>
                                        <th> @lang('common.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (isset($issuedItems))
                                        @foreach ($issuedItems as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->items != '' ? $value->items->item_name : '' }}</td>
                                                <td>{{ $value->categories != '' ? $value->categories->category_name : '' }}</td>

                                                @if ($value->role_id == 2)
                                                    @php
                                                        $getMemberDetail = App\SmBook::getMemberDetails($value->issue_to);
                                                    @endphp
                                                @else
                                                    @php
                                                        $getMemberDetail = App\SmBook::getMemberStaffsDetails($value->issue_to);
                                                    @endphp
                                                @endif

                                                <td>
                                                    @if (!empty($getMemberDetail))
                                                        {{ $getMemberDetail->full_name }}
                                                    @endif
                                                </td>
                                                <td data-sort="{{ strtotime($value->issue_date) }}">
                                                    {{ $value->issue_date != '' ? dateConvert($value->issue_date) : '' }}

                                                </td>
                                                <td data-sort="{{ strtotime($value->due_date) }}">
                                                    {{ $value->due_date != '' ? dateConvert($value->due_date) : '' }}


                                                </td>

                                                <td>{{ $value->quantity }}</td>
                                                <td>
                                                    @if ($value->issue_status == 'I')
                                                        <button class="primary-btn small bg-success text-white border-0">
                                                            @lang('inventory.issued')</button>
                                                    @else
                                                        <button
                                                            class="primary-btn small bg-primary text-white border-0">@lang('inventory.returned')</button>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($value->issue_status == 'I')
                                                        <div class="dropdown">
                                                            <button type="button" class="btn dropdown-toggle"
                                                                data-toggle="dropdown">
                                                                @lang('common.select')
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @if (userPermission(347))
                                                                    <a class="dropdown-item modalLink"
                                                                        title="@lang('inventory.return_item')"
                                                                        data-modal-size="modal-md"
                                                                        href="{{ route('return-item-view', @$value->id) }}">@lang('inventory.return')</a>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
  <script>
      $(document).on('.issuedSubmit', 'click', function (e) {
          let issue_date = $('#startDate').val();
          let return_date = $('#endDate').val();
          alert(return_date);
          if(issue_date > return_date) {
            toastr.error("Return Date will be greater Than issue date");
            return;
            e.preventdefault();
          }
      })
  </script>
@endpush