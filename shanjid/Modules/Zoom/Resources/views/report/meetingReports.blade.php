@extends('backEnd.master')
@section('title')
    @lang('lang.meetings') @lang('lang.reports')
@endsection
@section('css')
<style>
    .propertiesname{
        text-transform: uppercase;
    }.
    .recurrence-section-hide {
       display: none!important
    }
    </style>
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.meetings') @lang('lang.reports') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.virtual_class')</a>
                <a href="#"> @lang('lang.reports') </a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="col-lg-10">
                <h3 class="mb-30">
                    @lang('lang.meetings') @lang('lang.reports')
                </h3>
            </div>
        </div>
        <div class="row mb-20">
            <div class="col-lg-12">
                <div class="white-box">
                    @if(userPermission(567) )
                        <form action="{{ route('zoom.meeting.reports.show') }}" method="GET">
                    @endif
                            <div class="row">
                                <div class="col-lg-4 mt-30-md">
                                    <select class="niceSelect w-100 bb user_type form-control" name="member_type">
                                        <option data-display=" @lang('lang.member_type') *" value="">@lang('lang.member_type') *</option>
                                        @foreach($roles as $value)
                                            @if(isset($member_type))
                                                <option value="{{$value->id}}" {{ $value->id == $member_type ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @else
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-30-md" id="select_user_div">
                                   
                                    <select id="select_user" class="w-100 niceSelect bb form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" name="teachser_ids">
                                        <option data-display="@lang('lang.select_teacher')" value="">@lang('lang.select_teacher')</option>
                                        @if(isset($editdata))
                                            @foreach($userList as $teacher)
                                                <option value="{{$teacher->id }}" {{ isset($editdata) == $teacher->id? 'selected':'' }} >{{$teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                
                                <div class="col-lg-2 mt-30-md">
                                    <input data-display="@lang('lang.from_date')" placeholder="@lang('lang.from_date')" class="primary-input date form-control" type="text" name="from_time" value="{{ isset($from_time) ? Carbon\Carbon::parse($from_time)->format('m/d/Y') : '' }}">
                                </div>
                                <div class="col-lg-2 mt-30-md">
                                    <input data-display="@lang('lang.to_date')" placeholder="@lang('lang.to_date')" class="primary-input date form-control" type="text" name="to_time" value="{{ isset($to_time) ? Carbon\Carbon::parse($to_time)->format('m/d/Y') : '' }}">
                                </div>

                                @php
                                    $tooltip = "";
                                        if(userPermission(568))
                                        {
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to search";
                                        }
                                @endphp

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg" data-toggle="tooltip" title="{{$tooltip}}">
                                        <span class="ti-search pr-2"></span>
                                        @lang('lang.search')
                                    </button>
                                </div>

                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area" style="display:  {{ isset($meetings) ? 'block' : 'none'  }} ">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="default_table2" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.meeting_id')</th>
                                    <th>@lang('lang.password')</th>
                                    <th>@lang('lang.topic')</th>
                                    <th>@lang('lang.participants')</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.time')</th>
                                    <th>@lang('lang.duration')</th>
                                </tr>
                        </thead>

                        <tbody>
                            @if (isset($meetings))
                                @foreach($meetings as $key => $meeting )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $meeting->meeting_id }}</td>
                                    <td>{{ $meeting->password }}</td>
                                    <td>{{ $meeting->topic }}  </td>
                                    <td>{{ $meeting->participatesName }}</td>
                                    <td>{{ $meeting->date_of_meeting }}</td>
                                    <td>{{ $meeting->time_of_meeting }}</td>
                                    <td>{{ $meeting->meeting_duration }} Min</td>
                                </tr>
                                @endforeach
                            @endif
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
        $(document).ready(function(){
            $(document).on('change','.user_type',function(){
                let userType = $(this).val();
               
                $.get('{{ route('zoom.user.list.user.type.wise') }}',{ user_type: userType },function(res){
                   
                    $.each(res, function(i, item) {
                        
                            $("#select_user").find("option").not(":first").remove();
                            $("#select_user_div ul").find("li").not(":first").remove();

                            $("#select_user").append(
                                $("<option>", {
                                    value: "all",
                                    text: "Select Member",
                                })
                            );
                            $.each(item, function(i, user) {
                                $("#select_user").append(
                                    $("<option>", {
                                        value: user.id,
                                        text: user.full_name,
                                    })
                                );

                                $("#select_user_div ul").append(
                                    "<li data-value='" +
                                    user.id +
                                    "' class='option'>" +
                                    user.full_name +
                                    "</li>"
                                );
                            });
                        
                    });


                    //
                })
            })
        })
    </script>
@stop
