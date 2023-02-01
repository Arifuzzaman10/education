@push('css')
    <link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}"/>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees::feesModule.fees_invoice')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees')</a>
                <a href="#">@lang('fees::feesModule.fees_invoice')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if (isset($role) && $role =='admin')
            @if(userPermission(1140))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-25">
                        <a href="{{route('fees.fees-invoice')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
        @endif
        <div class="row">
            @if(isset($role) && $role =='admin' || $role=='lms')
                <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('common.student')</th>
                            {{-- <th>@lang('student.class_section')</th> --}}
                            <th>@lang('accounts.amount')</th>
                            <th>@lang('fees::feesModule.waiver')</th>
                            <th>@lang('fees.fine')</th>
                            <th>@lang('fees.paid')</th>
                            <th>@lang('accounts.balance')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.date')</th>
                            <th>@lang('common.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if (isset($studentInvoices))
                                @foreach ($studentInvoices as $key=>$studentInvoice)
                                    @php
                                        $amount = $studentInvoice->Tamount;
                                        $weaver = $studentInvoice->Tweaver;
                                        $fine = $studentInvoice->Tfine;
                                        $paid_amount = $studentInvoice->Tpaidamount;
                                        $sub_total = $studentInvoice->Tsubtotal;
                                        $balance = ($amount+ $fine) - ($paid_amount + $weaver);
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <a href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}" target="_blank">
                                                {{@$studentInvoice->studentInfo->full_name}}
                                            </a>
                                        </td>
                                        {{-- <td>{{@$studentInvoice->recordDetail->class->class_name}} ({{@$studentInvoice->recordDetail->section->section_name}})</td> --}}
                                        <td>{{$amount}}</td>
                                        <td>{{$weaver}}</td>
                                        <td>{{$fine}}</td>
                                        <td>{{$paid_amount}}</td>
                                        <td>{{$balance}}</td>
                                        <td>
                                            @if ($balance == 0)
                                                <button class="primary-btn small bg-success text-white border-0">@lang('fees.paid')</button>
                                            @else
                                                @if ($paid_amount > 0)
                                                    <button class="primary-btn small bg-warning text-white border-0">@lang('fees.partial')</button>
                                                @else
                                                    <button class="primary-btn small bg-danger text-white border-0">@lang('fees.unpaid')</button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{dateConvert($studentInvoice->create_date)}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if (isset($role) && $role =='admin' || $role=='lms')
                                                        @if(userPermission(1141))
                                                            <a class="dropdown-item viewPaymentDetail" data-id="{{$studentInvoice->id}}">@lang('inventory.view_payment')</a>
                                                        @endif
                                                        @if ($balance == 0)
                                                            @if(userPermission(1142))
                                                                <a class="dropdown-item" href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}">@lang('common.view')</a>
                                                            @endif
                                                        @else
                                                            @if ($paid_amount > 0)
                                                                @if(userPermission(1142))
                                                                    <a class="dropdown-item" href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}">@lang('common.view')</a>
                                                                @endif
                                                                @if(userPermission(1144))
                                                                    <a class="dropdown-item" href="{{route('fees.add-fees-payment',$studentInvoice->id)}}">@lang('inventory.add_payment')</a>
                                                                @endif
                                                            @else
                                                                @if(userPermission(1142))
                                                                    <a class="dropdown-item" href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}">@lang('common.view')</a>
                                                                @endif
                                                                @if(userPermission(1144))
                                                                    <a class="dropdown-item" href="{{route('fees.add-fees-payment',$studentInvoice->id)}}">@lang('inventory.add_payment')</a>
                                                                @endif

                                                                @if(userPermission(1145))
                                                                    <a class="dropdown-item" href="{{route('fees.fees-invoice-edit',$studentInvoice->id)}}">@lang('common.edit')</a>
                                                                @endif

                                                                @if(userPermission(1146))
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#deleteFeesPayment{{$studentInvoice->id}}" href="#">@lang('common.delete')</a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Delete Modal Start --}}
                                    <div class="modal fade admin-query" id="deleteFeesPayment{{$studentInvoice->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('fees::feesModule.delete_fees_invoice')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                        {{ Form::open(['method' => 'POST','route' =>'fees.fees-invoice-delete']) }}
                                                            <input type="hidden" name="id" value="{{$studentInvoice->id}}">
                                                            <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Delete Modal End --}}
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="modal fade admin-query" id="viewFeesPayment">
                        <div class="modal-dialog modal-dialog-centered max_modal">
                            <div class="modal-content">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 student-details up_admin_visitor">
                    <ul class="nav nav-tabs tabs_scroll_nav ml-0" role="tablist">
                        @foreach($records as $key => $record)
                            <li class="nav-item">
                                <a class="nav-link @if($key== 0) active @endif " href="#tab{{$key}}" role="tab" data-toggle="tab">{{$record->class->class_name}} ({{$record->section->section_name}}) </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-40">
                        @foreach($records as $key=> $record)
                            <div role="tabpanel" class="tab-pane fade  @if($key== 0) active show @endif" id="tab{{$key}}">
                                <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('common.student')</th>
                                        <th>@lang('student.class_section')</th>
                                        <th>@lang('accounts.amount')</th>
                                        <th>@lang('fees::feesModule.waiver')</th>
                                        <th>@lang('fees.fine')</th>
                                        <th>@lang('fees.paid')</th>
                                        <th>@lang('accounts.balance')</th>
                                        <th>@lang('common.status')</th>
                                        <th>@lang('common.date')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($record->feesInvoice as $key=>$studentInvoice)
                                            @php
                                                $amount = $studentInvoice->Tamount;
                                                $weaver = $studentInvoice->Tweaver;
                                                $fine = $studentInvoice->Tfine;
                                                $paid_amount = $studentInvoice->Tpaidamount;
                                                $sub_total = $studentInvoice->Tsubtotal;
                                                $balance = ($amount+ $fine) - ($paid_amount + $weaver);
                                            @endphp
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    <a href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}" target="_blank">
                                                        {{@$studentInvoice->studentInfo->full_name}}
                                                    </a>
                                                </td>
                                                <td>{{@$studentInvoice->recordDetail->class->class_name}} ({{@$studentInvoice->recordDetail->section->section_name}})</td>
                                                <td>{{$amount}}</td>
                                                <td>{{$weaver}}</td>
                                                <td>{{$fine}}</td>
                                                <td>{{$paid_amount}}</td>
                                                <td>{{$balance}}</td>
                                                <td>
                                                    @if ($balance == 0)
                                                        <button class="primary-btn small bg-success text-white border-0">@lang('fees.paid')</button>
                                                    @else
                                                        @if ($paid_amount > 0)
                                                            <button class="primary-btn small bg-warning text-white border-0">@lang('fees.partial')</button>
                                                        @else
                                                            <button class="primary-btn small bg-danger text-white border-0">@lang('fees.unpaid')</button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{dateConvert($studentInvoice->create_date)}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                            @lang('common.select')
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{route('fees.fees-invoice-view',['id'=>$studentInvoice->id,'state'=>'view'])}}">@lang('common.view')</a>
                                                            @if ($balance != 0)
                                                                <a class="dropdown-item" href="{{route('fees.student-fees-payment',$studentInvoice->id)}}">@lang('inventory.add_payment')</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<script>
    $('.viewPaymentDetail').on('click', function(e) {
        $('#viewFeesPayment').modal('show');
        e.preventDefault();
        let invoiceId = $(this).data('id');

        $.ajax({
            url: "{{route('fees.fees-view-payment')}}",
            method: "POST",
            data : { invoiceId : invoiceId},
            success: function(response) {
                $('#viewFeesPayment .modal-content').html(response);
            },
        });
    });
    // $('[data-tooltip="tooltip"]').tooltip();
</script>