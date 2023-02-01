@extends('backEnd.master')
@section('title') 
@lang('lesson::lesson.edit_topic')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lesson::lesson.add_topic')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('lesson::lesson.lesson_plan')</a>
                <a href="#">@lang('lesson::lesson.topic')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($topicDetails))
        @if(userPermission(806))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('lesson.topic')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>

        @endif
        @endif


    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'lesson.topic.update',
    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
 

        <div class="row">
           
            <div class="col-lg-3">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($topic))
                                    @lang('lesson::lesson.edit_topic')
                                @else
                                    @lang('lesson::lesson.update_topic')
                                @endif
                               
                            </h3>
                        </div>
                        <div class="white-box">
                            <div class="add-visitor">
                           
                                <div class="row mt-25">
                                     <div class="col-lg-12">

                                       <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class" disabled="">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                        @foreach($classes as $class)                                      
                                        <option value="{{@$class->id}}"  {{ @$class->id == @$topic->class_id?'selected':''}}>{{@$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                </div> 
                                    <input type="hidden" name="topic_id" value="{{$topic->id}}">
                                <div class="row mt-25">

                                        <div class="col-lg-12" >

                                            <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_section" name="section" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($sections as $section)
                                            <option value="{{@$section->id}}" {{ @$section->id == @$topic->section_id?'selected':''}}>{{@$section->section_name}}</option>
                                            @endforeach
                                        </select>
                                                @if ($errors->has('section'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('section') }}</strong>
                                                </span>
                                                 @endif

                                        </div>
                                 </div>
                                       <div class="row mt-25">
                                     <div class="col-lg-12" id="">
                                         <select class="w-100 bb niceSelect form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} select_subject" id="select_subject" name="subject" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($subjects as $subject)
                                            <option value="{{@$subject->id}}" {{ @$subject->id == @$topic->subject_id?'selected':''}}>{{@$subject->subject_name}} ({{$subject->subject_type=='T' ? 'Theory' : 'Practical'}})</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('subject'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                      </div>  
                                </div>
                                <div class="row mt-25">

                                        <div class="col-lg-12" id="select_lesson_div">

                                           <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_lesson" id="select_lesson" name="lesson" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($lessons as $lesson)
                                            <option value="{{@$lesson->id}}" {{ @$lesson->id == @$topic->lesson_id?'selected':''}}>{{@$lesson->lesson_title}}</option>
                                            @endforeach

                                                </select>
                                                @if ($errors->has('lesson'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('lesson') }}</strong>
                                                </span>
                                            @endif

                                        </div>
                                 </div>

                             
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box mt-10">
                               <div class="row">
                               
                                </div>
                            <table  id="productTable">
                                <thead>
                                    <tr>
                                  
                                      
                                    </tr>
                                </thead>
                                @foreach($topicDetails as $topicData)
                                <tbody>
                                    <input type="hidden" name="topic_detail_id[]" value="{{$topicData->id}}">
                                  <tr id="row1">
                                    <td class="pt-2">
                                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
                                           <input type="hidden"  id="lang" value="@lang('lesson::lesson.title')">  
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('topic') ? ' is-invalid' : '' }}"
                                                type="text" id="topic" name="topic[]" autocomplete="off" value="{{isset($topicData)? $topicData->topic_title : '' }}" required="" style="padding-top: 20px;">
                                                <label style="top: -5px">@lang('lesson::lesson.title')</label>
                                        </div>
                                    </td>
                                 
                                    <td class="pt-2">
                                        
                                        <a href="" data-toggle="modal" data-target="#deleteTopicTitle{{$topicData->id}}">
                                         <button class="primary-btn icon-only fix-gr-bg" type="button">
                                             <span class="ti-trash"></span>
                                        </button>
                                        </a>
                                       
                                    </td>
                                    </tr>
                                 
                               </tbody>
                               <div class="modal fade admin-query" id="deleteTopicTitle{{$topicData->id}}" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('common.delete_topic')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="text-center">
                                                <h4>@lang('common.are_you_sure_to_delete')</h4>
                                            </div>

                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                              
                                                  <a href="{{route('topicTitle-delete',[$topicData->id])}}"  class="primary-btn fix-gr-bg">@lang('common.delete')</a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                               @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                               @php 
                                  $tooltip = "";
                                  if(userPermission(807)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="white-box">                               
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                  <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{ @$tooltip}}">
                                                        <span class="ti-check"></span>
                                                        @if(isset($data))
                                                            @lang('lesson::lesson.update_topic')
                                                        @else
                                                            @lang('lesson::lesson.update_topic')
                                                        @endif
                                                      

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
            {{ Form::close() }}

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('lesson::lesson.topic_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                      
                                        <tr>
                                            <th>@lang('common.sl')</th>                                       
                                            <th>@lang('common.class')</th>
                                            <th>@lang('common.section')</th>
                                            <th>@lang('lesson::lesson.subject')</th>
                                            <th>@lang('lesson::lesson.lesson')</th>
                                            <th>@lang('lesson::lesson.topic')</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                            </thead>

                                     
                                     <tbody>
                                      @php $count =1 ; @endphp
                                        @foreach($topics as $data)

                                        <tr>
                                            <td>{{$count++}}</td>

                                            <td>{{$data->class !=""?$data->class->class_name:""}}</td>
                                            <td>{{$data->section !=""?$data->section->section_name:""}}</td>
                                            <td>{{$data->subject !=""?$data->subject->subject_name:""}}</td>
                                           
                                            <td>{{$data->lesson !=""?$data->lesson->lesson_title:""}}

                                            </td>

                                            <td>
                                               
                                                @foreach($data->topics as $topicData)
                                                {{$topicData->topic_title}}
                                                {{!$loop->last ? ',' : ''}}
                                                <br>
                                                @endforeach
                                            </td>
                                         

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                        @lang('common.select')
                                                    </button>
                                                  
                                                       
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if(userPermission(807))
                                                            <a class="dropdown-item"
                                                                href="{{route('topic-edit', $data->id)}}">@lang('common.edit')</a>
                                                         @endif
                                                        @if(userPermission(808))
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteExamModal{{$data->id}}"
                                                                href="#">@lang('common.delete')</a>
                                                         @endif
                                                    </div>
                                                    
                                                </div> 
                                            </td>
                                        </tr>
                                            <div class="modal fade admin-query" id="deleteExamModal{{$data->id}}" >
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">@lang('common.delete_exam')</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                            </div>

                                                            <div class="mt-40 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                                 {{ Form::open(['route' => array('topic-delete',$data->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
