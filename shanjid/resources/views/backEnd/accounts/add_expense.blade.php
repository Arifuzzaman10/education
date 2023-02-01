@extends('backEnd.master')
@section('title') 
@lang('accounts.add_expense')
@endsection
@section('mainContent')
@php  $setting = app('school_info'); if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; } @endphp

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.add_expense') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard') </a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.add_expense')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($add_expense))
        @if(userPermission(144))
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('add-expense')}}" class="primary-btn small fix-gr-bg">
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
                                @if(isset($add_expense))
                                    @lang('accounts.edit_expense')
                                @else
                                    @lang('accounts.add_expense')
                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($add_expense))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true,  'route' => array('add-expense-update',@$add_expense->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data' , 'id' => 'add-expense-update']) }}
                        @else
                        @if(userPermission(144))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'add-expense',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-expense']) }}
                        @endif
                        @endif
                        
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($add_expense)? $add_expense->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_expense)? $add_expense->id: ''}}">
                                            <label>@lang('common.name')  <span>*</span></label>
                                            <span class="focus-border"></span>
                                             @if (@$errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                 <div class="row  mt-40">
                                    <div class="col-lg-12">

                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('expense_head') ? ' is-invalid' : '' }}" name="expense_head">
                                            <option data-display="@lang('accounts.a_c_Head') *" value="">@lang('accounts.a_c_Head') *</option>
                                            @foreach($expense_heads as $expense_head)
                                                @if(isset($add_expense))
                                                <option value="{{@$expense_head->id}}"
                                                    {{@$add_expense->expense_head_id == @$expense_head->id? 'selected': ''}}>{{@$expense_head->head}}</option>
                                                @else
                                                <option value="{{@$expense_head->id}}" {{old('expense_head') == @$expense_head->id? 'selected': ''}}>{{@$expense_head->head}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                       @if ($errors->has('expense_head'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('expense_head') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="payment_method">
                                            <option data-display="@lang('accounts.payment_method') *" value="">@lang('accounts.payment_method') *</option>
                                            @foreach($payment_methods as $payment_method)
                                            @if(isset($add_expense))
                                            <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}"
                                                {{@$add_expense->payment_method_id == @$payment_method->id? 'selected': ''}}>{{@$payment_method->method}}</option>
                                            @else
                                                <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}" {{old('payment_method') == @$payment_method->id? 'selected': ''}}>{{@$payment_method->method}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('payment_method'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('payment_method') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-25 d-none" id="bankAccount">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('accounts') ? ' is-invalid' : '' }}" name="accounts">
                                            <option data-display="@lang('accounts.bank_accounts') *" value="">@lang('accounts.bank_accounts')  *</option>
                                            @foreach($bank_accounts as $bank_account)
                                            @if(isset($add_expense))
                                            <option value="{{@$bank_account->id}}"
                                                {{@$add_expense->account_id == @$bank_account->id? 'selected': ''}}>{{@$bank_account->account_name}} ({{@$bank_account->bank_name}})</option>
                                            @else
                                            <option value="{{@$bank_account->id}}">{{@$bank_account->account_name}} ({{@$bank_account->bank_name}})</option>
                                            @endif
                                            @endforeach
                                        </select> 
                                        @if ($errors->has('accounts'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('accounts') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>

                                <div class="row no-gutters input-right-icon mt-40">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ @$errors->has('date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                placeholder="@lang('common.date') " name="date" value="{{isset($add_expense)? date('m/d/Y',strtotime($add_expense->date)) : date('m/d/Y')}}">
                                            <span class="focus-border"></span>
                                              @if ($errors->has('date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('date') }}</strong>
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
                                <div class="row  mt-40">
                                    <div class="col-lg-12">

                                        <div class="input-effect">
                                            <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ @$errors->has('amount') ? ' is-invalid' : '' }}"
                                                type="text" name="amount" step="0.1" autocomplete="off" value="{{isset($add_expense)? $add_expense->amount:old('amount')}}">
                                            <label>@lang('accounts.amount')  <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('amount') }}</strong>
                                            </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                     <div class="col">
                                        <div class="row no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{isset($add_expense)? ($add_expense->file != ""? getFilePath3($add_expense->file): trans('common.file')) :  trans('common.file')}}"readonly
                                                        >
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                     @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="primary-btn-small-input" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="document_file_1">@lang('common.browse') </label>
                                                    <input type="file" class="d-none" name="file" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control" cols="0" rows="4" name="description">{{isset($add_expense)? $add_expense->description: old('description')}}</textarea>
                                            <label>@lang('common.description')  <span></span></label>
                                            <span class="focus-border textarea"></span>
                                        </div>
                                    </div>
                                </div>
                                  @php 
                                  $tooltip = "";
                                  if(userPermission(144)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($add_expense))
                                                @lang('accounts.update_expense')
                                            @else
                                                @lang('accounts.save_expense')
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
                            <h3 class="mb-0">@lang('accounts.expense_list') </h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                                
                                <tr>
                                    <th>@lang('common.name') </th>
                                    <th>@lang('accounts.payment_method') </th>
                                    <th>@lang('common.date') </th>
                                    <th>@lang('accounts.a_c_Head') </th>
                                    <th>@lang('accounts.amount') ({{@generalSetting()->currency_symbol}})</th>
                                    <th>@lang('common.action') </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($add_expenses as $add_expense)
                                <tr>
                                    <td>{{@$add_expense->name}}</td>
                                    <td>{{@$add_expense->paymentMethod !=""?@$add_expense->paymentMethod->method:""}} {{@$add_expense->payment_method_id == "3"? '('.@$add_expense->account->account_name.')':''}}</td>
                                    <td data-sort="{{strtotime(@$add_expense->date)}}">
                                        {{@$add_expense->date != ""? dateConvert(@$add_expense->date):''}}</td>
                                    <td>{{isset($add_expense->ACHead->head)? $add_expense->ACHead->head: ''}}</td>
                                    <td>{{@$add_expense->amount}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(145))

                                                <a class="dropdown-item" href="{{route('add-expense-edit', [@$add_expense->id])}}">@lang('common.edit') </a>
                                                @endif
                                                @if(userPermission(146))

                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteAddExpenseModal{{@$add_expense->id}}"
                                                    href="#">@lang('common.delete') </a>
                                                @endif
                                                @if($add_expense->file != "")
                                                    <a class="dropdown-item" href="{{url(@$add_expense->file)}}" download>
                                                        @lang('common.download') 
                                                        <span class="pl ti-download"></span>
                                                    </a>
                                                @endif
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteAddExpenseModal{{@$add_expense->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('accounts.delete_item') </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete') </h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel') </button>
                                                     {{ Form::open(['route' => array('add-expense-delete',@$add_expense->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete') </button>
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
