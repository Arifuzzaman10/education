@extends('backEnd.master')
@section('title') 
@lang('admin.student_certificate')
@endsection
@push('css')
    <style>
        .certificate-middle {
            margin-bottom: 280px;
        }

        .student-certificate .certificate-position {
            position: absolute;
            top: 19%;
        }
    </style>
@endpush

@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('admin.student_certificate')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('admin.admin_section')</a>
                <a href="#">@lang('admin.student_certificate')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($certificate))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('student-certificate')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        <div class="row">
           
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($certificate))
                                    @lang('admin.edit_certificate')
                                @else
                                    @lang('admin.add_certificate')
                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($certificate))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('student-certificate-update',$certificate->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                          @if(userPermission(50))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-certificate',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($certificate)? $certificate->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($certificate)? $certificate->id: ''}}">
                                            <label>@lang('admin.certificate_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('header_left_text') ? ' is-invalid' : '' }}"
                                                type="text" name="header_left_text" autocomplete="off" value="{{isset($certificate)? $certificate->header_left_text: old('header_left_text')}}">
                                            <label>@lang('admin.header_left_text')<span></span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('header_left_text'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('header_left_text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="startDate" type="text" name="date" autocomplete="off" value="{{isset($certificate)? date('m/d/Y', strtotime($certificate->date)): date('m/d/Y')}}">
                                            <span class="focus-border"></span>
                                            <label>@lang('common.date') <span></span></label>
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

                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" cols="0" rows="4" name="body" maxlength="500">{{isset($certificate)? $certificate->body: old('body')}}</textarea>
                                            <label>@lang('admin.body_max_character_lenght_500') <span></span></label>
                                            <span class="focus-border textarea"></span>

                                            @if($errors->has('body'))
                                                <span class="error text-danger"><strong>{{ $errors->first('body') }}</strong></span>
                                            @endif
                                        </div>
                                        <span class="text-primary">[name] [dob] [present_address] [guardian] [created_at] [admission_no] [roll_no] [class] [section] [gender] [admission_date] [category] [cast] [father_name] [mother_name] [religion] [email] [phone]</span>
                                    </div>
                                </div>

                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('footer_left_text') ? ' is-invalid' : '' }}"
                                                type="text" name="footer_left_text" autocomplete="off" value="{{isset($certificate)? $certificate->footer_left_text: old('footer_left_text')}}">
                                            <label>@lang('admin.footer_left_text') <span></span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('footer_left_text'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('footer_left_text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('footer_center_text') ? ' is-invalid' : '' }}"
                                                type="text" name="footer_center_text" autocomplete="off" value="{{isset($certificate)? $certificate->footer_center_text: old('footer_center_text')}}">
                                            <label>@lang('admin.footer_center_text')<span></span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('footer_center_text'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('footer_center_text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('footer_right_text') ? ' is-invalid' : '' }}"
                                                type="text" name="footer_right_text" autocomplete="off" value="{{isset($certificate)? $certificate->footer_right_text: old('footer_right_text')}}">
                                            <label>@lang('admin.footer_right_text')<span></span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('footer_right_text'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('footer_right_text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12 d-flex">
                                        <p class="text-uppercase fw-500 mb-10">@lang('admin.student_photo')</p>
                                        <div class="d-flex radio-btn-flex ml-40">
                                            <div class="mr-30">
                                                <input type="radio" name="student_photo" id="relationFather" value="1" class="common-radio relationButton" {{isset($certificate)? ($certificate->student_photo == 1? 'checked': ''):'checked'}}>
                                                <label for="relationFather">@lang('common.yes')</label>
                                            </div>
                                            <div class="mr-30">
                                                <input type="radio" name="student_photo" id="relationMother" value="0" class="common-radio relationButton" {{isset($certificate)? ($certificate->student_photo == 0? 'checked': ''):''}}>
                                                <label for="relationMother">@lang('common.none')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row no-gutters input-right-icon mt-35">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" id="placeholderInput" type="text" placeholder="{{isset($certificate)? ($certificate->file != ""? getFilePath3($certificate->file):trans('common.image') .' *'): trans('common.image') .' (1100 X 850)px *'}}" readonly>
                                            <span class="focus-border"></span>
                                            
                                            @if ($errors->has('file'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('file') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="browseFile">@lang('common.browse')</label>
                                            <input type="file" class="d-none" id="browseFile" name="file" value="{{isset($certificate)? ($certificate->file != ""? getFilePath3($certificate->file):''): ''}}">
                                        </button>
                                    </div>
                                    
                                </div>
	                           @php 
                                  $tooltip = "";
                                  if(userPermission(50)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($certificate))
                                                @lang('admin.update_certificate')
                                            @else
                                                @lang('admin.save_certificate')
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

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">  @lang('admin.certificate_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                                
                                <tr>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('admin.background_image')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($certificates as $certificate)
                                <tr>
                                    <td><a class="text-color" data-toggle="modal" data-target="#showCertificateModal{{ @$certificate->id}}"  href="#">{{ @$certificate->name}}</a></td>
                                    <td>
                                        @if (@$certificate->file)
                                            <img src="{{url(@$certificate->file)}}" width="100">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#showCertificateModal{{ @$certificate->id}}"  href="#">@lang('common.view')</a>
                                                 @if(userPermission(51))
                                                <a class="dropdown-item" href="{{route('student-certificate-edit',@$certificate->id)}}">@lang('common.edit')</a>
                                                @endif
                                                 @if(userPermission(52))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteSectionModal{{ @$certificate->id}}"  href="#">@lang('common.delete')</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteSectionModal{{@$certificate->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('admin.delete_certificate')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    {{ Form::open(['route' => array('student-certificate-delete',@$certificate->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade admin-query" id="showCertificateModal{{ @$certificate->id}}">
                                    <div class="modal-dialog modal-dialog-centered large-modal">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('admin.view_certificate')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="container student-certificate">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="mb-5">
								                                <img class="img-fluid" src="{{asset($certificate->file)}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-10 text-center certificate-position">
                                                            <div>
                                                                <div class="row justify-content-lg-between mb-5">
                                                                    <div class="col-md-5">
                                                                        <p class="m-0">{{ @$certificate->header_left_text}}:</p>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <p class="m-0">@lang('admin.date'): {{ @$certificate->date }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="certificate-middle">
                                                                    <p>
                                                                        {{ @$certificate->body }}
                                                                    </p>
                                                                </div>

                                                                <div class="mt-80 mb-4">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text-center">
                                                                            <div class="signature bb-15">{{ @$certificate->footer_left_text }}</div>
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                            <div class="signature bb-15">{{ @$certificate->footer_center_text }}</div>
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                            <div class="signature bb-15">{{ @$certificate->footer_right_text }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
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
@section('script')
    <script>
        @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
        @endif
    </script>
@endsection