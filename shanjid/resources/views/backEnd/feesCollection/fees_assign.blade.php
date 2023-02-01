@extends('backEnd.master')
@section('title') 
@lang('fees.fees_collection')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees.fees_assign')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees_collection')</a>
                <a href="{{route('fees_assign', [$fees_group_id])}}">@lang('fees.fees_assign')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                      
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'fees-assign-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_studentA']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <input type="hidden" name="fees_group_id" id="fees_group_id" value="{{@$fees_group_id}}">
                                @if(moduleStatusCheck('University'))
                                    @includeIf('university::common.session_faculty_depart_academic_semester_level',['hide'=>['USUB']])
                                @else     
                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class')</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{@$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                     @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-30-md" id="select_section_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('common.select_section')" value="">@lang('common.select_section')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                        <option data-display="@lang('fees.select_category')" value="">@lang('fees.select_category')</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{isset($category_id)? ($category_id == $category->id? 'selected':''):''}}>{{@$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-30-md">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('group') ? ' is-invalid' : '' }}" name="group">
                                        <option data-display="@lang('fees.select_group')" value="">@lang('fees.select_group')</option>
                                        @foreach($groups as $group)
                                        <option value="{{$group->id}}" {{isset($group_id)? ($group_id == $group->id? 'selected':''):''}}>{{$group->group}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('group'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('group') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @endif

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('common.search')
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        @if(isset($students))
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'url' => 'btn-assign-fees-group', 'enctype' => 'multipart/form-data'])}}
            {{-- {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'url' => 'fees-assign-store', 'enctype' => 'multipart/form-data'])}} --}}
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row mb-30">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('fees.assign_fees_group')</h3>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="fees_group_id" value="{{@$fees_group_id}}" id="fees_group_id">
                    <input type="hidden" class="assigned_status" value="{{@$assigned_value}}">
                    <input type="hidden" name="class_id" value="{{@$class_id}}" id="class_id">
                    <input type="hidden" name="section_id" value="{{@$section_id}}" id="section_id">

                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-4">
                            
                            <table id="table_id_table" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        @php $i = 0; @endphp
                                        @foreach($fees_assign_groups as $fees_assign_group)
                                        @php $i++; @endphp
                                        @if($i == 1)

                                            <tr>
                                                <th>{{@$fees_assign_group->feesGroups->name}}</th>
                                                <th>@lang('fees.amount') </th>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fees_assign_groups as $fees_assign_group)
                                    <tr>
                                        <td>
                                            {{@$fees_assign_group->feesTypes !=""?@$fees_assign_group->feesTypes->name:""}}
                                        </td>
                                        <td>{{@$fees_assign_group->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        
                        <div class="col-lg-8">
                            <div class="table-responsive">
                            <table  class="display school-table school-table-style" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">
                                            <input type="checkbox" id="checkAll" class="common-checkbox" name="checkAll"  @php
                                                if(count($students) > 0){
                                                    if(count($students) == count($pre_assigned)){
                                                        echo 'checked';
                                                    }

                                                }
                                            @endphp>
                                            <label for="checkAll">@lang('fees.all')</label>
                                        </th>
                                        <th width="20%">@lang('student.student_name')</th>
                                        <th width="15%">@lang('student.admission_no')</th>
                                        <th width="15%">@lang('common.class')</th>
                                        <th width="20%">@lang('student.father_name')</th>
                                        <th width="10%">@lang('fees.category')</th>
                                        <th width="10%">@lang('common.gender')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    
                                    <tr  @php if(in_array($student->id, $pre_assigned)){echo 'style="background-color:#efeaf7"'; } @endphp>
                                        <td>
                                            <input type="checkbox" id="student.{{$student->id}}" class="common-checkbox" name="data[{{$loop->index}}][checked]" value="1" {{in_array($student->id, $pre_assigned)? 'checked':''}}>
                                            <label for="student.{{$student->id}}"></label>

                                            <input type="hidden" name="data[{{$loop->index}}][class_id]" value="{{@$student->class->id}}">
                                            <input type="hidden" name="data[{{$loop->index}}][section_id]" value="{{@$student->section->id}}">
                                            <input type="hidden" name="data[{{$loop->index}}][record_id]" value="{{@$student->id}}">
                                        </td>
                                        <td>{{@$student->studentDetail->full_name}} 
                                            <input type="hidden" name="data[{{$loop->index}}][student_id]" value="{{isset($update)? $student->forwardBalance->id: $student->student_id}}">
                                        </td>
                                        <td>{{@$student->studentDetail->admission_no}}</td>
                                        <td>{{@$student->class->class_name.'('.@$student->section->section_name.')'}}</td>

                                        <td>{{$student->studentDetail->parents != ""? $student->studentDetail->parents->fathers_name:""}}</td>
                                        <td>{{@$student->studentDetail->category->category_name}}</td>
                                        <td>{{@$student->studentDetail->gender->base_setup_name}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                @if($students->count() > 0)
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center">
                                            <button type="submit" class="primary-btn fix-gr-bg mb-0 submit" id="btn-assign-fees-group" data-loading-text="<i class='fas fa-spinner'></i> Processing Data">
                                                <span class="ti-save pr"></span>
                                                @lang('fees.save_fees')
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    {{ Form::close() }}
    @endif

    </div>
</section>

@endsection
