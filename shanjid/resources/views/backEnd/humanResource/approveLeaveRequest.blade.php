
@extends('backEnd.master')
@php $pending = Illuminate\Support\Str::contains(Request::path(), 'pending');  @endphp
@section('title') 
@if ($pending)
                        @lang('leave.pending_leave_request')
                    @else
                        @lang('leave.approve_leave_request')
                    @endif
@endsection
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid p-0">
            <div class="row justify-content-between">
               
                <h1>
                    @if ($pending)
                        @lang('leave.pending_leave_request')
                    @else
                        @lang('leave.approve_leave_request')
                    @endif
                </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('leave.leave')</a>
                    @php $pending = Illuminate\Support\Str::contains(Request::path(), 'pending');  @endphp

                    @if ($pending)
                        <a href="#">@lang('leave.pending_leave_request')</a>
                    @else
                        <a href="#">@lang('leave.approve_leave_request')</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 no-gutters">
                    <div class="main-title">
                        @php $pending = Illuminate\Support\Str::contains(Request::path(), 'pending');  @endphp

                        @if ($pending)
                            <h3>@lang('leave.pending_leave_request')
                                <h3>
                                    @else
                                        <h3>@lang('leave.approve_leave_request')<h3>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                        <thead>
                        
                        <tr>
                            <th>@lang('common.name')</th>
                            <th>@lang('common.type')</th>
                            <th>@lang('common.from')</th>
                            <th>@lang('common.to')</th>
                            <th>@lang('leave.apply_date')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.action')</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($apply_leaves as $apply_leave)
                            <tr>
                                @if ($apply_leave->role_id == 2)
                                    <td>{{$apply_leave->student != ""? $apply_leave->student->full_name:''}}</td>
                                @else
                                    <td>{{$apply_leave->staffs != ""? $apply_leave->staffs->full_name:''}}</td>
                                @endif
                                <td>
                                    @if($apply_leave->leaveDefine !="" && $apply_leave->leaveDefine->leaveType !="")
                                        {{$apply_leave->leaveDefine->leaveType->type}}
                                    @endif
                                </td>
                                <td data-sort="{{strtotime($apply_leave->leave_from)}}">
                                    {{$apply_leave->leave_from != ""? dateConvert($apply_leave->leave_from):''}}

                                </td>
                                <td data-sort="{{strtotime($apply_leave->leave_to)}}">
                                    {{$apply_leave->leave_to != ""? dateConvert($apply_leave->leave_to):''}}

                                </td>
                                <td data-sort="{{strtotime($apply_leave->apply_date)}}">
                                    {{$apply_leave->apply_date != ""? dateConvert($apply_leave->apply_date):''}}

                                </td>
                                <td>

                                    @if($apply_leave->approve_status == 'P')
                                        <button class="primary-btn bg-warning text-white border-0 small tr-bg">@lang('common.pending')</button>@endif

                                    @if($apply_leave->approve_status == 'A')
                                        <button class="primary-btn bg-success text-white border-0 small tr-bg">@lang('common.approved')</button>
                                    @endif

                                    @if($apply_leave->approve_status == 'C')
                                        <button class="primary-btn small bg-danger text-white border-0">@lang('common.cancelled')</button>
                                    @endif

                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            @if(userPermission(191))

                                                <a data-modal-size="modal-lg" title="View/Edit Leave Details"
                                                   class="dropdown-item modalLink"
                                                   href="{{  route('view-leave-details-approve', [@$apply_leave->id]) }}">@lang('common.view')
                                                    /@lang('common.approved')</a>

                                            @endif

                                            @if(userPermission(192))

                                                <a class="dropdown-item" data-toggle="modal"
                                                   data-target="#deleteApplyLeaveModal{{$apply_leave->id}}"
                                                   href="#">@lang('common.delete')</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade admin-query" id="deleteApplyLeaveModal{{$apply_leave->id}}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('common.delete_item')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="text-center">
                                                <h4>@lang('common.are_you_sure_to_delete')</h4>
                                            </div>

                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg"
                                                        data-dismiss="modal">@lang('common.cancel')</button>
                                                {{ Form::open(['route' => array('apply-leave-delete',$apply_leave->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                <button class="primary-btn fix-gr-bg"
                                                        type="submit">@lang('common.delete')</button>
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
    </section>
@endsection
