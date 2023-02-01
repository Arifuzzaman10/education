@extends('backEnd.master')
@section('title')
@lang('library.add_book')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('library.add_book')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('library.library')</a>
                    @if(isset($editData))
                        <a href="#">@lang('library.edit_book')</a>
                    @else
                        <a href="#">@lang('library.add_book')</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
          <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title ">
                        <h3 class="mb-30">
                            @if(isset($editData))
                                @lang('library.edit_book')
                            @else
                                @lang('library.add_book')
                            @endif
                           
                    </div>
                </div>
            </div>
            @if(isset($editData))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('update-book-data',$editData->id), 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            @else
                @if(userPermission(300))
        
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-book-data',
                    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                @endif
            @endif

            <div class="row">
                <div class="col-lg-12">
                    @include('backEnd.partials.alertMessage')
                    <div class="white-box">
                        <div class="">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="row mb-30">
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input
                                            class="primary-input form-control{{ $errors->has('book_title') ? ' is-invalid' : '' }}"
                                            type="text" name="book_title" autocomplete="off"
                                            value="{{isset($editData)? $editData->book_title :(old('book_title')!=''? old('book_title'):'')}}">
                                        <label>@lang('library.book_title') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('book_title'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('book_title') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select
                                            class="niceSelect w-100 bb form-control{{ $errors->has('book_category_id') ? ' is-invalid' : '' }}"
                                            name="book_category_id" id="book_category_id">
                                            <option data-display="@lang('library.select_book_category') *"
                                                    value="">@lang('common.select')</option>
                                            @foreach($categories as $key=>$value)
                                                @if(isset($editData))
                                                    <option
                                                        value="{{$value->id}}" {{$value->id == $editData->book_category_id? 'selected':''}}>{{$value->category_name}}</option>
                                                @else
                                                    <option
                                                        value="{{$value->id}}" {{old('book_category_id')!=''? (old('book_category_id') == $value->id? 'selected':''):''}} >{{$value->category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('book_category_id'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('book_category_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select
                                            class="niceSelect w-100 bb form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}"
                                            name="subject" id="subject">
                                            <option data-display="@lang('common.select_subjects')"
                                                    value="">@lang('common.select')</option>
                                            @foreach($subjects as $key=>$value)
                                                @if(isset($editData))
                                                    <option value="{{$value->id}}" {{$value->id == $editData->book_subject_id? 'selected':''}}>{{$value->subject_name}}</option>
                                                    @else
                                                    <option value="{{$value->id}}" {{old('subject')!=''? (old('subject') == $value->id? 'selected':''):''}} >{{$value->subject_name}}</option>
                                                @endif
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
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input
                                            class="primary-input form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                            type="text" name="book_number" autocomplete="off"
                                            value="{{isset($editData)? $editData->book_number: old('book_number')}}">
                                        <label>@lang('library.book_no')</label>
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
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="numberCheckWithDot(this)"
                                            class="primary-input form-control{{ $errors->has('isbn_no') ? ' is-invalid' : '' }}"
                                            type="text" name="isbn_no" autocomplete="off"
                                            value="{{isset($editData)? $editData->isbn_no: old('isbn_no')}}">
                                        <label>@lang('library.isbn_no')</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('isbn_no'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('isbn_no') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input
                                            class="primary-input form-control{{ $errors->has('publisher_name') ? ' is-invalid' : '' }}"
                                            type="text" name="publisher_name" autocomplete="off"
                                            value="{{isset($editData)? $editData->publisher_name: old('publisher_name')}}">
                                        <label>@lang('library.publisher_name')</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('publisher_name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('publisher_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input
                                            class="primary-input form-control{{ $errors->has('author_name') ? ' is-invalid' : '' }}"
                                            type="text" name="author_name" autocomplete="off"
                                            value="{{isset($editData)? $editData->author_name: old('author_name')}}">
                                        <label>@lang('library.author_name')</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('author_name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('author_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-30">

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input
                                            class="primary-input form-control{{ $errors->has('rack_number') ? ' is-invalid' : '' }}"
                                            type="text" name="rack_number" autocomplete="off"
                                            value="{{isset($editData)? $editData->rack_number: old('rack_number')}}">
                                        <label>@lang('library.rack_number')</label>
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
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="numberMinCheck(this)"
                                            class="primary-input form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                            type="text" name="quantity" autocomplete="off"
                                            value="{{isset($editData)? $editData->quantity : old('quantity')}}">
                                        <label>@lang('library.quantity')</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('quantity'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="numberMinZeroCheck(this)"
                                            class="primary-input form-control{{ $errors->has('book_price') ? ' is-invalid' : '' }}"
                                            type="text" name="book_price" autocomplete="off"
                                            value="{{isset($editData)? $editData->book_price : old('book_price')}}">
                                        <label>@lang('library.book_price')</label>
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
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <textarea class="primary-input form-control" cols="0" rows="4" name="details"
                                                  id="details">{{isset($editData) ? $editData->details : old('details')}}</textarea>
                                        <label>@lang('common.description') <span></span> </label>
                                        <span class="focus-border textarea"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                          @php 
                              $tooltip = "";
                              if(userPermission(300)){
                                    $tooltip = "";
                                }else{
                                    $tooltip = "You have no permission to add";
                                }
                            @endphp
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                    <span class="ti-check"></span>
                                    @if(isset($editData))
                                        @lang('library.update_book')
                                    @else
                                        @lang('library.save_book')
                                    @endif
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
