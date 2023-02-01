@extends('backEnd.master')
@section('title') 
@lang('leave.child_leave')
@endsection

@section('mainContent')

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('leave.leave')</h1>
            <div class="bc-pages">
                <a href="{{route('parent-dashboard')}}">@lang('common.dashboard')</a>
                
                <a href="#">@lang('leave.child_leave')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor pl_22">
<div class="container-fluid p-0">
    {{-- <div class="row mb-30">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4 no-gutters">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('leave.my_remaining_leaves')</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    <table class="display school-table school-table-style" cellspacing="0" width="100%">

                        <thead>
                            
                            <tr>
                                <th>@lang('common.type')</th>
                                <th>@lang('leave.remaining_days')</th>
                                <th>@lang('leave.extra_taken')</th>
                                <th>@lang('leave.total_days')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($my_leaves as $my_leave)
                            @php

                            $approved_leaves = App\SmLeaveRequest::approvedLeave($my_leave->id);
                                $remaining_days = $my_leave->days - $approved_leaves;
                            @endphp
                            <tr>
                                <td>{{$my_leave->leaveType !=""?$my_leave->leaveType->type:""}}</td>
                                <td>{{$remaining_days >= 0? $remaining_days:0}}</td>

                                <td>{{$remaining_days < 0? $approved_leaves - $my_leave->days:0}}</td>
                                <td>{{$my_leave->days}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
   
<div class="row">
   
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">@lang('leave.leave_list') </h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                    <thead>
                       
                        <tr>
                            <th>@lang('common.type')</th>
                            <th>@lang('common.from')</th>
                            <th>@lang('common.to')</th>
                            <th>@lang('leave.apply_date')</th>
                            <th>@lang('common.status')</th>
                            {{-- <th>@lang('common.action')</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($apply_leaves as $apply_leave)
                        <tr>
                            <td>
                                @if($apply_leave->leaveDefine != "" && $apply_leave->leaveDefine->leaveType !="")
                                    {{$apply_leave->leaveDefine->leaveType->type}}
                                @endif
                            </td>
                            <td  data-sort="{{strtotime($apply_leave->leave_from)}}" >
                             {{$apply_leave->leave_from != ""? dateConvert($apply_leave->leave_from):''}}

                            </td>
                            <td  data-sort="{{strtotime($apply_leave->leave_to)}}" >
                               {{$apply_leave->leave_to != ""? dateConvert($apply_leave->leave_to):''}}

                            </td>
                            <td  data-sort="{{strtotime($apply_leave->apply_date)}}" >
                              {{$apply_leave->apply_date != ""? dateConvert($apply_leave->apply_date):''}}

                            </td>
                            <td>
                            @if($apply_leave->approve_status == 'P')
                            <button class="primary-btn small bg-warning text-white border-0 tr-bg">@lang('common.pending')</button>@endif
                            @if($apply_leave->approve_status == 'A')
                            <button class="primary-btn small bg-success text-white border-0 tr-bg">@lang('common.approved')</button>
                            @endif
                            @if($apply_leave->approve_status == 'C')
                            <button class="primary-btn small bg-approved text-white border-0 tr-bg">@lang('leave.cancelled')</button>
                            @endif
                            </td>
                            {{-- <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('common.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        @if(in_array(194, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                        <a data-modal-size="modal-lg" title="View Leave Details" class="dropdown-item modalLink" href="{{url('view-leave-details-apply', $apply_leave->id)}}">@lang('common.view')</a>

                                        @endif
                                        @if($apply_leave->approve_status == 'P')
                                        @if(in_array(396, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 2 )

                                        <a class="dropdown-item" href="{{url('student-leave-edit', [$apply_leave->id
                                            ])}}">edit</a> 

                                        @endif
                                        @if(in_array(195, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                         <a class="dropdown-item" data-toggle="modal" data-target="#deleteApplyLeaveModal{{$apply_leave->id}}"
                                            href="#">@lang('common.delete')</a>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </td> --}}
                        </tr>
                        <div class="modal fade admin-query" id="deleteApplyLeaveModal{{$apply_leave->id}}" >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('leave.delete_apply_leave')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                        </div>

                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                             {{ Form::open(['route' => array('parent-leave-delete',$apply_leave->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                            <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
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
@endsection
