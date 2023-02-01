@extends('backEnd.master')
@section('title')
@lang('library.book_category')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('library.book_category')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('library.library')</a>
                <a href="#">@lang('library.book_category')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($editData))
        @if(userPermission(305))
           
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('book-category-list')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($editData))
                                    @lang('common.edit')
                                @else
                                    @lang('common.add')
                                @endif
                                @lang('library.book_category')
                            </h3>
                        </div>
                        @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('book-category-list-update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                         @if(userPermission(305))
           
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'book-category-list',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">                                  

                                    <div class="col-lg-12 mb-20">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('category_name') ? ' is-invalid' : '' }}"
                                            type="text" name="category_name" autocomplete="off" value="{{isset($editData)? $editData->category_name : Request::old('category_name') }}">
                                            <label>@lang('library.category_name') <span>*</span> </label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('category_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                                </div>
                                  @php 
                                  $tooltip = "";
                                  if(userPermission(305)){
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
                                                @lang('library.update_category')
                                            @else
                                                @lang('library.save_category')
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
                    <h3 class="mb-0">@lang('student.category_list')</h3>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                    <thead>
                        
                        <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('student.category_title')</th>
                            <th>@lang('common.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        @foreach($bookCategories as $key=>$value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$value->category_name}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('common.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    @if(userPermission(306))
                                         <a class="dropdown-item" href="{{route('book-category-list-edit',$value->id)}}">@lang('common.edit')</a>
                                    @endif
                                    @if(userPermission(307))
                                         <a class="dropdown-item" data-toggle="modal" data-target="#deleteCategoryModal{{$value->id}}"  href="#">@lang('common.delete')</a>
                                    @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade admin-query" id="deleteCategoryModal{{$value->id}}" >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('library.delete_category')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                        </div>

                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                            {{ Form::open(['route' => array('book-category-list-delete',$value->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
