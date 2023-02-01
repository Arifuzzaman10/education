@extends('backEnd.master')
@section('title') 
@lang('accounts.payment_method')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.payment_method')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.payment_method')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($payment_method))
         @if(userPermission(153))
                      
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('payment_method')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        @endif
        <div class="row">
          
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($payment_method))
                                    @lang('common.edit')
                                @else
                                    @lang('common.add')
                                @endif
                                @lang('accounts.payment_method')
                            </h3>
                        </div>
                        @if(isset($payment_method))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'payment_method_update',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @else
                          @if(userPermission(153))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'payment_method_store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(session()->has('message-success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success') }}
                                        </div>
                                        @elseif(session()->has('message-danger'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger') }}
                                        </div>
                                        @endif
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('method') ? ' is-invalid' : '' }}"
                                                type="text" name="method" autocomplete="off" value="{{isset($payment_method)? $payment_method->method: old('method')}}">
                                            <input type="hidden" name="id" value="{{isset($payment_method)? $payment_method->id: ''}}">
                                            <label>@lang('accounts.method') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('method'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('method') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            	@php 
                                  @$tooltip = "";
                                  if(userPermission(153)){
                                        @$tooltip = "";
                                    }else{
                                        @$tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                      <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($payment_method))
                                                @lang('common.update')
                                            @else
                                                @lang('common.save')
                                            @endif
                                           @lang('common.method')
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
                            <h3 class="mb-0">@lang('accounts.payment_method_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                                @if(session()->has('message-success-delete') != "" ||
                                session()->get('message-danger-delete') != "")
                                <tr>
                                    <td colspan="6">
                                        @if(session()->has('message-success-delete'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success-delete') }}
                                        </div>
                                        @elseif(session()->has('message-danger-delete'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger-delete') }}
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>@lang('accounts.method')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($payment_methods as $payment_method)
                                 @if(moduleStatusCheck('RazorPay') == FALSE && $payment_method->method == "RazorPay")
                                 @else
                                <tr>
                                    <td>{{@$payment_method->method}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            @if( @$payment_method->type != "System")
                                            <div class="dropdown-menu dropdown-menu-right">
                                               @if(userPermission(154))

                                                <a class="dropdown-item" href="{{route('payment_method_edit', [@$payment_method->id])}}">@lang('common.edit')</a>
                                                @endif
                                                @if(userPermission(155))

                                                <a class="dropdown-item" data-toggle="modal" data-target="#deletePaymentMethodModal{{@$payment_method->id}}"
                                                    href="#">@lang('common.delete')</a>
                                           @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif


                                <div class="modal fade admin-query" id="deletePaymentMethodModal{{@$payment_method->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('common.delete_payment_method')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <a href="{{route('payment_method_delete', [@$payment_method->id])}}" class="text-light">
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                     </a>
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
