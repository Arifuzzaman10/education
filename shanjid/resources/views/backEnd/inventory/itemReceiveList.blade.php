@extends('backEnd.master')
@section('title')
@lang('inventory.item_receive_list')
@endsection
@section('mainContent')
@php  $setting = generalSetting(); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('inventory.item_receive_list')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('inventory.inventory')</a>
                <a href="#">@lang('inventory.item_receive_list')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                
            </div>
             @if(userPermission(335))
            <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg">
                <a href="{{route('item-receive')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('inventory.new_item_receive')
                </a>
            </div>
            @endif
        </div>

 <div class="row mt-40">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4 no-gutters">
                    <div class="main-title">
                        <h3 class="mb-0">@lang('inventory.item_receive_list')</h3>
                    </div>
                </div>
            </div>

         <div class="row">
                <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                            
                            <tr>
                                <th>@lang('common.sl')</th>
                                <th>@lang('inventory.reference_no')</th>
                                <th>@lang('inventory.supplier_company_name')</th>
                                <th>@lang('common.date')</th>
                                <th>@lang('inventory.grand_total')</th>
                                <th>@lang('inventory.total_quantity')</th>
                                <th>@lang('inventory.paid')</th>
                                <th>@lang('inventory.balance') ({{$currency}})</th>
                                <th>@lang('common.status')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($allItemReceiveLists))
                            @foreach($allItemReceiveLists as $key=>$value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{$value->reference_no}}</td>
                               
                                <td>{{$value->suppliers !=""?$value->suppliers->company_name:""}}</td>
                                <td  data-sort="{{strtotime($value->receive_date)}}" >
                                  {{$value->receive_date != ""? dateConvert($value->receive_date):''}}
                                </td>
                                
                                <td>{{number_format( (float) $value->grand_total, 2, '.', '')}}</td>
                                <td>{{$value->total_quantity}}</td>
                                <td>{{number_format( (float) $value->total_paid, 2, '.', '')}}</td>
                                <td>{{number_format( (float) $value->total_due, 2, '.', '')}}</td>
                                <td>
                                    @if($value->paid_status == 'P')
                                    <button class="primary-btn small bg-success text-white border-0">@lang('inventory.paid')</button>
                                    @elseif($value->paid_status == 'PP')
                                    <button class="primary-btn small bg-warning text-white border-0">@lang('inventory.partial')</button>
                                    @elseif($value->paid_status == 'U')
                                    <button class="primary-btn small bg-danger text-white border-0">@lang('inventory.unpaid')</button>
                                    @else
                                    <button class="primary-btn small bg-info text-white border-0">@lang('inventory.refund')</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('view-item-receive', $value->id)}}">@lang('common.view')</a>
                                            @php
                                            $itemPaymentdetails = App\SmInventoryPayment::itemPaymentdetails($value->id);
                                            @endphp

                                            @if($value->paid_status != 'R')
                                            @if($itemPaymentdetails == 0)
                                            @if(userPermission(336))
                                            <a class="dropdown-item" href="{{route('edit-item-receive', $value->id)}}">@lang('common.edit')</a>
                                            @endif
                                            @endif
                                            @endif

                                             @if($value->paid_status != 'R')
                                             @if($value->total_due > 0)
                                             <a class="dropdown-item modalLink" title="Add Payment" data-modal-size="modal-md" href="{{route('add-payment',$value->id)}}">@lang('common.add_payment')</a>
                                             @endif
                                             @endif

                                             @if($value->paid_status != 'P')
                                                @if(userPermission(337))
                                              <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="View Payments" href="{{route('view-receive-payments', $value->id)}}">@lang('common.view_payment')</a>
                                              @endif
                                              @endif

                                                @if($value->paid_status != 'R')
                                                @if($value->total_paid == 0)
                                                 @if(userPermission(338))
                                                <a class="dropdown-item deleteUrl" data-modal-size="modal-md" title="@lang('inventory.delete_item_receive')" href="{{route('delete-item-receive-view', $value->id)}}">@lang('common.delete')</a>
                                                @endif
                                                @endif
                                                @endif

                                                @if($value->paid_status != 'R')
                                                    @if($value->total_paid>0)

                                                        <a class="dropdown-item deleteUrl" data-modal-size="modal-md" title="Cancel Item Receive" href="{{route('cancel-item-receive-view', $value->id)}}">@lang('common.cancel')</a>
                                                    @endif
                                                @endif                                           
                                        </div>
                                    </div>
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
