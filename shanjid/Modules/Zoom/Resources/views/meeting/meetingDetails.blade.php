@extends('backEnd.master')
@section('mainContent')
<style>
    .propertiesname{
        text-transform: uppercase;
        font-weight:bold;
    }
    </style>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.meeting')  @lang('lang.details')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.meeting')</a>
                <a href="#">@lang('lang.details') </a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-10">
                <h3 class="mb-30"> @lang('lang.topic') : {{@$results['topic']}}</h3>
            </div>
            <div class="col-md-2 pull-right  text-right">
                @if(userPermission(557))
                    <a href="{{ route('zoom.meetings.edit', $localMeetingData->id) }}" class="primary-btn small fix-gr-bg "> <span class="ti-pencil-alt"></span> @lang('lang.edit') </a>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="" class="display school-table school-table-style" cellspacing="0" width="100%">

                            <tr>
                                <th>#</th>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.status')</th>
                            </tr>
                            @php $sl = 1 @endphp
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.topic')</td> <td>{{@$results['topic']}}</td>
                            </tr>
                               @if($localMeetingData->weekly_days !=null)
                                <tr>
                                    <td>{{ $sl++ }} </td> 
                                    <td class="propertiesname">@lang('lang.repeat') @lang('lang.day')</td>
                                    <td> @foreach ($assign_day as $day)
                                        {{$day->name}},
                                    @endforeach  </td>
                                </tr>
                            @endif 
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.participants')</td> <td> {{ $localMeetingData->participatesName }}  </td>
                            </tr>
                            @if($localMeetingData->attached_file)
                                <tr>
                                    <td>{{ $sl++ }} </td> <td class="propertiesname"> @lang('lang.attached_file') </td> <td> <a href="{{ asset($localMeetingData->attached_file) }}" download="" ><i class="fa fa-download mr-1"></i> Download</a>  </td>
                                </tr>
                            @endif
                            <tr>
                                <td> {{ $sl++ }} </td> <td class="propertiesname">@lang('lang.start_date_time')</td> <td>{{ $localMeetingData->MeetingDateTime }}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td>
                                <td class="propertiesname">@lang('lang.video') @lang('lang.link')  </td>
                                <td>
                                    {{ $localMeetingData->vedio_link }}  
                                </td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td>
                                <td class="propertiesname"> @lang('lang.recorded') @lang('lang.video')   </td>
                                <td>
                                     @if($localMeetingData->local_video) <a href="{{ asset($localMeetingData->local_video) }}" download="" ><i class="fa fa-download mr-1"></i> Download</a> @else No File  @endif  </td>

                                 
                                </td>
                            </tr>
                            <tr>
                                <td> {{ $sl++ }} </td> <td class="propertiesname">@lang('lang.meeting_id')</td> <td>{{ @$results['id'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.password')</td> <td>{{@$results['password']}}</td>
                            </tr>
                                @if(userPermission(559))
                                    <tr>
                                        <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.zoom_start_join')</td> <td>
                                            @if(@$results['status'] == 'started')
                                                <a class="primary-btn small bg-success text-white border-0" href="{{ route('zoom.meeting.join', $localMeetingData->meeting_id) }}" target="_blank" >
                                                    @if (Auth::user()->role_id == 1 || Auth::user()->id == $localMeetingData->created_by)
                                                        @lang('lang.start')
                                                    @else
                                                        @lang('lang.join')
                                                    @endif
                                                </a>
                                            @elseif(@$results['status'] == 'waiting')
                                                <a href="#Waiting" class="primary-btn small bg-warning text-white border-0">@lang('lang.not_yet_start')</button>
                                            @else
                                                <a href="#Closed" class="primary-btn small bg-warning text-white border-0">>@lang('lang.closed')</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.host_id')</td> <td>{{@$results['host_id']}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.description')</td> <td> {{ $localMeetingData->description }}  </td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.status')</td> <td>{{@$results['status']}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.timezone')</td> <td>{{@$results['timezone']}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.created_at') </td> <td>{{Carbon\Carbon::parse(@$results['created_at'])->format('m-d-Y')}}</td>
                            </tr>
                            @if(userPermission(559))
                                <tr>
                                    <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.join_url')</td> <td> <a href="{{@$results['join_url']}}" target="_blank" >Click</a></td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">h323 @lang('lang.password')</td> <td>{{@$results['h323_password']}}</td>
                            </tr>

                            <tr>
                                <td>11</td> <td class="propertiesname">@lang('lang.encrypted')  @lang('lang.password')</td> <td>{{@$results['encrypted_password']}}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.host_video')</td> <td>{{@$results['settings']['host_video']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.participant_video')</td> <td>{{@$results['settings']['participant_video']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.cn_mettings')</td> <td>{{@$results['settings']['cn_mettings']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.in_mettings')</td> <td>{{@$results['settings']['in_mettings']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.join_before_host')</td> <td>{{@$results['settings']['join_before_host']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lan.mute_upon_entry')</td> <td>{{@$results['settings']['mute_upon_entry']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lan.watermark')</td> <td>{{@$results['settings']['watermark']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.use_pmi')</td> <td>{{@$results['settings']['use_pmi']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.audio_options')</td> <td>{{@$results['settings']['audio']}}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.auto_recording')</td> <td>{{@$results['settings']['auto_recording']}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.enforce_login')</td> <td>{{@$results['settings']['enforce_login']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.enforce_login_domains') </td> <td>{{@$results['settings']['enforce_login_domains']==false?'False':'True'}}</td>
                            </tr>

                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.alternative_hosts')</td> <td>{{@$results['settings']['alternative_hosts']==false?'False':'True'}}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.waiting_room')</td> <td>{{@$results['settings']['waiting_room']==false?'False':'True'}}</td>
                            </tr>
                            <tr>
                                <td>{{ $sl++ }} </td> <td class="propertiesname">@lang('lang.meeting_authentication')</td> <td>{{@$results['settings']['meeting_authentication']==false?'False':'True'}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
