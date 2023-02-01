@extends('backEnd.master')
@section('title')
@lang('common.subject')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('common.subject')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('library.library')</a>
                <a href="#">@lang('common.subject')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($subject))
          @if(userPermission(580) )
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('library_subject')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($subject))
                                    @lang('library.edit_subject')
                                @else
                                    @lang('library.add_subject')
                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($subject))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'library_subject_update', 'method' => 'POST']) }}
                        @else
                        @if(userPermission(580) )
      
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'library_subject_store', 'method' => 'POST']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('subject_name') ? ' is-invalid' : '' }}" 
                                            type="text" name="subject_name" autocomplete="off" value="{{isset($subject)? $subject->subject_name: old('subject_name')}}">
                                            <input type="hidden" name="id" value="{{isset($subject)? $subject->id: ''}}">
                                            <label>@lang('library.subject_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('subject_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('subject_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-40 d-none">
                                    <div class="col-lg-12">
                                        <div class="d-flex radio-btn-flex">
                                            @if(isset($subject))
                                            <div class="mr-30 d-none">
                                                <input type="radio" name="subject_type" id="relationFather" value="T" class="common-radio relationButton" {{@$subject->subject_type == 'T'? 'checked':''}}>
                                                <label for="relationFather">@lang('library.theory')</label>
                                            </div>
                                            <div class="mr-30">
                                                <input type="radio" name="subject_type" id="relationMother" value="P" class="common-radio relationButton" {{@$subject->subject_type == 'P'? 'checked':''}}>
                                                <label for="relationMother">@lang('library.practical')</label>
                                            </div>
                                            @else
                                            <div class="mr-30">
                                                <input type="radio" name="subject_type" id="relationFather" value="T" class="common-radio relationButton" checked>
                                                <label for="relationFather">@lang('library.theory')</label>
                                            </div>
                                            <div class="mr-30">
                                                <input type="radio" name="subject_type" id="relationMother" value="P" class="common-radio relationButton">
                                                <label for="relationMother">@lang('library.practical')</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-40">
                                    <div class="col-lg-12 ">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                            <option data-display=" @lang('library.category_name')" value="">@lang('library.category_name')</option>
                                            @foreach($bookCategories as $value)
                                                @if(isset($subject))
                                                    <option value="{{$value->id}}" {{$value->id == $subject->sb_category_id? 'selected':''}}>{{$value->category_name}}</option>
                                                @else
                                                    <option value="{{$value->id}}">{{$value->category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            

                                <div class="row  mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('subject_code') ? ' is-invalid' : '' }}" type="text" name="subject_code" autocomplete="off" value="{{isset($subject)? $subject->subject_code: old('subject_code')}}">
                                            <label>@lang('library.subject_code') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('subject_code'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('subject_code') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                 @php 
                                  $tooltip = "";
                                  if(userPermission(580) ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($subject))
                                                @lang('library.update_subject')
                                            @else
                                                @lang('library.save_subject')
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
                            <h3 class="mb-0">@lang('library.subject_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                               
                                <tr>
                                    <th> @lang('common.sl')</th>
                                    <th> @lang('common.subject')</th>
                                    <th> @lang('library.category_name')</th>
                                    <th>@lang('library.subject_code')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i=0; @endphp
                                @foreach($subjects as $subject)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{@$subject->subject_name}}</td>
                                    <td>{{@$subject->category_name}}</td>
                                    <td>{{@$subject->subject_code}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(581))
                                                    <a class="dropdown-item" href="{{route('library_subject_edit', [@$subject->id])}}">@lang('common.edit')</a>
                                                @endif
                                                @if(userPermission(582))
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#deleteSubjectModal{{@$subject->id}}"  href="#">@lang('common.delete')</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                 <div class="modal fade admin-query" id="deleteSubjectModal{{@$subject->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('library.delete_subject')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <a href="{{route('library_subject_delete', [@$subject->id])}}" class="text-light">
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
