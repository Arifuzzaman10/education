@extends('backEnd.master')
@section('title') 
@lang('accounts.bank_account')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.bank_account')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.bank_account')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($bank_account))
            @if(userPermission(157))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('bank-account')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">
                                @if(isset($bank_account))
                                    @lang('accounts.edit_bank_account')
                                @else
                                    @lang('accounts.add_bank_account')
                                @endif
                            </h3>
                        </div>
                        @if(isset($bank_account))
                            {{ Form::open(['class' => 'form-horizontal', 'route' => array('bank-account-update',@$bank_account->id), 'method' => 'PUT']) }}
                        @else
                            @if(userPermission(157))
                                {{ Form::open(['class' => 'form-horizontal', 'route' => 'bank-account', 'method' => 'POST']) }}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('bank_name') ? ' is-invalid' : '' }}" type="text" name="bank_name" autocomplete="off" value="{{isset($bank_account)? $bank_account->bank_name : old('bank_name')}}">
                                            <label>@lang('accounts.bank_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('bank_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('bank_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('account_name') ? ' is-invalid' : '' }}" type="text" name="account_name" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_name:old('account_name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_income)? $add_income->id: ''}}">
                                            <label>@lang('accounts.account_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('account_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('account_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('account_number') ? ' is-invalid' : '' }}" type="tel" name="account_number" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_number:old('account_number')}}">
                                            <label>@lang('accounts.account_number') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('account_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('account_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('account_type') ? ' is-invalid' : '' }}" type="text" name="account_type" autocomplete="off" value="{{isset($bank_account)? $bank_account->account_type:old('account_type')}}">
                                            <label>@lang('accounts.account_type')</label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('account_type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('account_type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row  mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ @$errors->has('opening_balance') ? ' is-invalid' : '' }}" type="text" step="0.1" name="opening_balance" autocomplete="off" value="{{isset($bank_account)? $bank_account->opening_balance:old('opening_balance')}}">
                                            <input type="hidden" name="id" value="{{isset($bank_account)? $bank_account->id: ''}}">
                                            <label>@lang('accounts.opening_balance')<span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('opening_balance'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('opening_balance') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control" cols="0" rows="4" name="note">{{isset($bank_account)? $bank_account->note: old('note')}}</textarea>
                                            <label>@lang('common.note') <span></span></label>
                                            <span class="focus-border textarea"></span>
                                        </div>
                                    </div>
                                </div>

                            	@php 
                                  $tooltip = "";
                                  if(userPermission(157)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp

                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($bank_account))
                                                @lang('accounts.update_account')
                                            @else
                                                @lang('accounts.save_account')
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
                            <h3 class="mb-0">@lang('accounts.bank_account_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('accounts.bank_name')</th>
                                    <th>@lang('accounts.account_name')</th>
                                    <th>@lang('accounts.opening_balance')</th>
                                    <th>@lang('accounts.current_balance')</th>
                                    <th>@lang('common.note')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bank_accounts as $bank_account)
                                <tr>
                                    <td>{{@$bank_account->bank_name}}</td>
                                    <td>{{@$bank_account->account_name}}</td>
                                    <td>{{generalSetting()->currency_symbol}}{{number_format(@$bank_account->opening_balance, 2)}}</td>
                                    <td>{{generalSetting()->currency_symbol}}{{number_format(@$bank_account->current_balance, 2)}}</td>
                                    <td>{{@$bank_account->note}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                               <!-- @if(userPermission(158))
                                                <a class="dropdown-item" href="{{route('bank-account-edit', [$bank_account->id])}}">@lang('common.edit')</a>
                                                @endif -->
                                                @if(userPermission(158))
                                                    <a class="dropdown-item" href="{{route('bank-transaction',[$bank_account->id])}}">@lang('accounts.transaction')</a>
                                                @endif
                                                @if(userPermission(159))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteBankAccountModal{{@$bank_account->id}}"
                                                    href="#">@lang('common.delete')</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteBankAccountModal{{@$bank_account->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('accounts.delete_bank_account')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                     {{ Form::open(['route' => array('bank-account-delete',@$bank_account->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
