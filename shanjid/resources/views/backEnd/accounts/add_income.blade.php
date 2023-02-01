@extends('backEnd.master')
@section('title') 
@lang('accounts.add_income')
@endsection
@section('mainContent')

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.add_income') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.add_income')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($add_income))
        @if(userPermission(140))

        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('add_income')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($add_income))
                                    @lang('accounts.edit_income')
                                @else
                                    @lang('accounts.add_income')
                                @endif
                                
                            </h3>
                        </div>
                        @if(isset($add_income))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'add_income_update',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income-update']) }}
                        @else
                         @if(userPermission(140))

                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'add_income_store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($add_income)? $add_income->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_income)? $add_income->id: ''}}">
                                            <label>@lang('common.name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row  mt-25">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('income_head') ? ' is-invalid' : '' }}" name="income_head">
                                            <option data-display="@lang('accounts.a_c_Head') *" value="">@lang('accounts.a_c_Head') *</option>
                                            @foreach($income_heads as $income_head)
                                                @if(isset($add_income))
                                                <option value="{{@$income_head->id}}"
                                                    {{@$add_income->income_head_id == @$income_head->id? 'selected': ''}}>{{@$income_head->head}}</option>
                                                @else
                                                <option value="{{@$income_head->id}}" {{old('income_head') == @$income_head->id? 'selected' : ''}}>{{@$income_head->head}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if (@$errors->has('income_head'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('income_head') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="payment_method">
                                            <option data-display="@lang('accounts.payment_method') *" value="">@lang('accounts.payment_method') *</option>
                                            @foreach($payment_methods as $payment_method)
                                            @if(isset($add_income))
                                            <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}"{{@$add_income->payment_method_id == @$payment_method->id? 'selected': ''}}>
                                                {{@$payment_method->method}}
                                            </option>
                                            @else
                                            <option data-string="{{$payment_method->method}}" value="{{@$payment_method->id}}">{{@$payment_method->method}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @if (@$errors->has('payment_method'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ @$errors->first('payment_method') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-25 d-none" id="bankAccount">
                                    <div class="col-lg-12">
                                        <select class="niceSelect w-100 bb form-control{{ @$errors->has('accounts') ? ' is-invalid' : '' }}" name="accounts">
                                            <option data-display="@lang('accounts.bank_accounts') *" value="">@lang('accounts.bank_accounts') *</option>
                                            @foreach($bank_accounts as $bank_account)
                                            @if(isset($add_income))
                                            <option value="{{@$bank_account->id}}"
                                                {{@$add_income->account_id == @$bank_account->id? 'selected': ''}}>{{@$bank_account->account_name}} ({{@$bank_account->bank_name}})</option>
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


                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ @$errors->has('date') ? ' is-invalid' : '' }}"
                                                id="startDate" type="text" placeholder="@lang('common.date') *" name="date" value="{{isset($add_income)? date('m/d/Y', strtotime($add_income->date)): date('m/d/Y')}}">
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
                                <div class="row  mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ @$errors->has('amount') ? ' is-invalid' : '' }}"
                                                type="text" step="0.1" name="amount" value="{{isset($add_income)? $add_income->amount: old('amount')}}">
                                            <label>@lang('accounts.amount') ({{generalSetting()->currency_symbol}}) <span>*</span></label>
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
                                                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{isset($add_income)? ($add_income->file != ""? getFilePath3($add_income->file):trans('common.file')):trans('common.file') }}" readonly
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
                                                    <label class="primary-btn small fix-gr-bg" for="document_file_1">@lang('common.browse')</label>
                                                    <input type="file" class="d-none" name="file" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control" cols="0" rows="4" name="description">{{isset($add_income)? $add_income->description: old('description')}}</textarea>
                                            <label>@lang('common.description') <span></span></label>
                                            <span class="focus-border textarea"></span>
                                        </div>
                                    </div>
                                </div>
                 				@php 
                                  $tooltip = "";
                                  if(userPermission(140)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if (@$add_income)
                                                 @lang('accounts.update_income')
                                            @else                                               
                                                @lang('accounts.save_income')
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
                            <h3 class="mb-0">@lang('accounts.income_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('accounts.payment_method')</th>
                                    <th>@lang('common.date')</th>
                                    <th>
                                        @lang('accounts.a_c_Head') 
                                    </th>
                                    <th>@lang('accounts.amount')({{generalSetting()->currency_symbol}})</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($add_incomes as $add_income)
                                <tr>
                                    <td>{{@$add_income->name}}</td>
                                    <td>{{@$add_income->paymentMethod !=""?@$add_income->paymentMethod->method:trans('accounts.bank')}} {{@$add_income->payment_method_id == "3"? '('.@$add_income->account->account_name.')':''}}</td>
                                    <td>{{@$add_income->date != ""? dateConvert(@$add_income->date):''}}</td>
                                    <td>
                                        {{isset($add_income->ACHead->head)? $add_income->ACHead->head: ''}}
                                        @if($add_income->description)
                                            <i class="ti-info" data-toggle="tooltip" title="{{ $add_income->description }}"></i>
                                        @endif
                                    </td>
                                    <td>{{@$add_income->amount}}</td>
                                    <td>
                                        @if ($add_income->name != "Opening Balance")
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                            
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if(userPermission(141))
                                                        <a class="dropdown-item" href="{{route('add_income_edit', [@$add_income->id])}}">@lang('common.edit')</a>
                                                    @endif
                                                    @if(@$add_income->file != "")
                                                            <a class="dropdown-item" 
                                                                href="{{url(@$add_income->file)}}" download>
                                                                @lang('common.download') <span class="pl ti-download"></span>
                                                            </a>
                                                        @endif
                                                        @if(userPermission(142))
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteAddIncomeModal{{@$add_income->id}}">@lang('common.delete')</a>
                                                        @endif
                                                    </div>
                                            
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteAddIncomeModal{{@$add_income->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('common.delete_income')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    {{ Form::open(['route' => 'add_income_delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                    <input type="hidden" name="id" value="{{@$add_income->id}}">
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
