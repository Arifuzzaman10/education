@extends('backEnd.master')
@section('title')
@lang('inventory.issue_item')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('inventory.issue_item')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('inventory.inventory')</a>
                <a href="{{route('issue-new-item')}}">@lang('inventory.issue_item')</a>
          </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="main-title">
                    <h3 class="mb-30">
                        @lang('inventory.issue_item')
                    </h3>
                </div>
            </div>
        </div>

        @if(isset($editData))
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('update-book-data',$editData->id), 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        @else
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-book-data',
        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        @endif

        <div class="row">
            <div class="col-lg-12">
                @include('backEnd.partials.alertMessage')   
                <div class="white-box">
                    <div class="">
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
                        <div class="row mb-30">
                            <div class="col-lg-3">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('member_type') ? ' is-invalid' : '' }}" name="member_type" id="member_type">
                                            <option data-display="Member Type *" value="">@lang('common.member_type') *</option>
                                            @foreach($roles as $value)
                                            @if(isset($editData))
                                            <option value="{{$value->id}}" {{$value->id == $editData->role_id? 'selected':''}}>{{$value->name}}</option>
                                            @else
                                            <option value="{{$value->id}}">{{$value->name}}</option>

                                            @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('member_type'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('member_type') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" id="subject">
                                        <option data-display="Select Subject *" value="">@lang('common.select')</option>
                                        @foreach($subjects as $key=>$value)
                                        <option value="{{$value->id}}"
                                        @if(isset($editData))
                                        @if($editData->subject == $value->id)
                                        selected
                                        @endif
                                        @endif
                                        >{{$value->subject_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('subject'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                    type="text" name="book_number" autocomplete="off" value="{{isset($editData)? $editData->book_number:''}}">
                                    <label>@lang('inventory.book_none')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('book_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('book_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div class="row mb-30">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ $errors->has('isbn_no') ? ' is-invalid' : '' }}"
                                    type="text" name="isbn_no" autocomplete="off" value="{{isset($editData)? $editData->isbn_no:''}}">
                                    <label>@lang('inventory.isbn_none')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('isbn_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('isbn_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('publisher_name') ? ' is-invalid' : '' }}"
                                    type="text" name="publisher_name" autocomplete="off" value="{{isset($editData)? $editData->publisher_name:''}}">
                                    <label>@lang('inventory.publisher_name')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('publisher_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('publisher_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('author_name') ? ' is-invalid' : '' }}"
                                    type="text" name="author_name" autocomplete="off" value="{{isset($editData)? $editData->author_name:''}}">
                                    <label>@lang('inventory.author_name')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('author_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('author_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('rack_number') ? ' is-invalid' : '' }}"
                                    type="text" name="rack_number" autocomplete="off" value="{{isset($editData)? $editData->rack_number:''}}">
                                    <label>@lang('inventory.rack_number') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('rack_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rack_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row mb-30">

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input oninput="numberCheck(this)" class="primary-input form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                    type="text" name="quantity" autocomplete="off" value="{{isset($editData)? $editData->quantity : ' '}}">
                                    <label>@lang('inventory.quantity')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('quantity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input oninput="numberCheckWithDot(this)" class="primary-input form-control{{ $errors->has('book_price') ? ' is-invalid' : '' }}"
                                    type="text" name="book_price" autocomplete="off" value="{{isset($editData)? $editData->book_price : ''}}">
                                    <label>@lang('inventory.book_price')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('book_price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('book_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row md-20">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <textarea class="primary-input" cols="0" rows="4" name="details" id="details">{{isset($editData) ? $editData->details : ''}}
                                    </textarea>
                                    <label>@lang('common.description') <span></span> </label>
                                    <span class="focus-border textarea"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg">
                                <span class="ti-check"></span>
                                @if(isset($editData))
                                @lang('common.update')
                                @else
                                @lang('common.add')
                                @endif

                                @lang('inventory.book')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
</section>
@endsection
