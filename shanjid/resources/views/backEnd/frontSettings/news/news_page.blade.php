@extends('backEnd.master')
@section('title')
@lang('front_settings.add_news')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.news_list')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#"> @lang('front_settings.front_settings')</a>
                    <a href="#">@lang('front_settings.news_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($add_news))
                @if(userPermission(497))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{route('news_index')}}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($add_news))
                                    @lang('front_settings.update_news')
                                @else
                                    @lang('common.add_news')
                                @endif
                             
                            </h3>
                        </div>
                        @if(isset($add_news))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update_news',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income-update']) }}
                        @else
                            @if(userPermission(497))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'store_news',
                                'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income']) }}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-effect">
                                                    <input
                                                            class="primary-input form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                            type="text" name="title" autocomplete="off"
                                                            value="{{isset($add_news)? $add_news->news_title: old('title')}}">
                                                    <input type="hidden" name="id"
                                                           value="{{isset($add_news)? $add_news->id: ''}}">
                                                    <label>@lang('front_settings.title') <span>*</span></label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('title'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row mt-25">
                                            <div class="col-lg-12">
                                                <div class="row no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="input-effect">
                                                            <input class="primary-input form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" type="text"
                                                                   id="placeholderFileOneName"
                                                                   placeholder="{{isset($add_news)? ($add_news->image !="") ? getFilePath3($add_news->image) :trans('front_settings.image').' *' :trans('front_settings.image').' *' }}"
                                                                   readonly>
                                                                   <span class="focus-border"></span>
                                                                    @if($errors->has('image'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('image') }}</strong>
                                                                        </span>
                                                                    @endif
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="document_file_1">@lang('common.browse')</label>
                                                            <input type="file" class="d-none" name="image"
                                                                   id="document_file_1">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <select
                                                        class="niceSelect w-100 bb form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                                        name="category_id">
                                                    <option data-display="@lang('common.select') *"
                                                            value="">@lang('common.select') *
                                                    </option>
                                                    @foreach($news_category as $value)
                                                        <option data-display="{{$value->category_name}}"
                                                                value="{{$value->id}}"
                                                                @if(isset($add_news))
                                                                @if($add_news->category_id == $value->id)
                                                                selected
                                                                @endif
                                                                @endif>
                                                            {{$value->category_name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                    <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row no-gutters input-right-icon mt-20">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input
                                                            class="primary-input date form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                                            id="startDate" type="text"
                                                            placeholder="@lang('common.date') *"
                                                            name="date"
                                                            value="{{isset($add_news)? date('m/d/Y', strtotime($add_news->publish_date)): date('m/d/Y')}}">
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('date'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date') }}</strong>
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
                                    </div>
                                    <div class="col-md-12 mt-20">
                                        <div class="input-effect">
                                            <label>@lang('common.description')* </label>
                                            <textarea class="primary-input form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" cols="0" rows="4" name="description" maxlength="500">{{isset($add_news)? $add_news->news_body: old('description')}}</textarea>
                                        
                                            <span class="focus-border textarea"></span>
                                            
                                            @if($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                    if(userPermission(497)){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to add";
                                        }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> <button class="primary-btn fix-gr-bg  demo_view" style="pointer-events: none;" type="button" >@lang('front_settings.update')</button></span>
                                        @else

                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($add_news))
                                                @lang('front_settings.update_news')
                                            @else
                                                @lang('common.add_news')
                                            @endif
                                           
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-5">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('front_settings.news_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                            
                            <tr>
                                <th>@lang('front_settings.title')</th>
                                <th>@lang('front_settings.publication_date')</th>
                                <th>@lang('student.category')</th>
                                <th>@lang('front_settings.image')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($news as $value)
                                <tr>
                                    <td>{{$value->news_title}}</td>
                                    <td data-sort="{{strtotime($value->publish_date)}}">
                                        {{$value->publish_date != ""? dateConvert($value->publish_date):''}}
                                    </td>
                                    <td>{{$value->category !=""?$value->category->category_name:""}}</td>
                                    <td><img src="{{asset($value->image)}}" width="60px" height="50px"></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(496) )
                                                    <a href="{{route('newsDetails',$value->id)}}"
                                                       class="dropdown-item small fix-gr-bg modalLink"
                                                       title="@lang('front_settings.news_details')" data-modal-size="modal-lg">
                                                        @lang('common.view')
                                                    </a>
                                                @endif
                                                @if(userPermission(498) )
                                                    <a class="dropdown-item"
                                                       href="{{route('edit-news',$value->id)}}">@lang('common.edit')</a>
                                                @endif
                                                @if(userPermission(499) )
                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                <span  tabindex="0" data-toggle="tooltip" title="Disabled For Demo"> <a href="#" class="dropdown-item small fix-gr-bg  demo_view" style="pointer-events: none;" >@lang('common.delete')</a></span>
                                                @else
                                                    <a href="{{route('for-delete-news',$value->id)}}"
                                                       class="dropdown-item small fix-gr-bg modalLink"
                                                       title="@lang('front_settings.delete_news')" data-modal-size="modal-md">
                                                        @lang('common.delete')
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    CKEDITOR.replace("description" );
</script>
@endpush
