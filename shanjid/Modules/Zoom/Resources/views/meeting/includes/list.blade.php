
 @if(Auth::user()->role_id == 1 )
    <div class="col-lg-9">
 @elseif(userPermission(561) && userPermission(560))
    <div class="col-lg-9">
 @else
    <div class="col-lg-12">
 @endif

    <div class="main-title">
        <h3 class="mb-0">
            @lang('lang.meeting')   @lang('lang.list')
        </h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>@lang('lang.meeting_id')</th>
                    <th>@lang('lang.password')</th>
                    <th>@lang('lang.topic')</th>
                    <th>@lang('lang.date')</th>
                    <th>@lang('lang.time')</th>
                    <th>@lang('lang.duration')</th>
                    <th>@lang('lang.zoom_start_join') @lang('lang.before')</th>
                    <th>@lang('lang.zoom_start_join')</th>
                    <th>@lang('lang.actions')</th>
                </tr>
            </thead>

            <tbody>
                @foreach($meetings as $key => $meeting )
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $meeting->meeting_id }}</td>
                    <td>{{ $meeting->password }}</td>
                    <td>{{ $meeting->topic }}</td>
                    <td>{{ $meeting->date_of_meeting }}</td>
                    <td>{{ $meeting->time_of_meeting }}</td>
                    <td>{{ $meeting->meeting_duration }} Min </td>                    
                    <td>{{ $meeting->time_before_start }} Min </td>
                    <td>
                        @if($meeting->currentStatus == 'started')
                            @if(userPermission(559))
                                <a class="primary-btn small bg-success text-white border-0" href="{{ route('zoom.meeting.join', $meeting->meeting_id) }}" target="_blank" >
                                    @if (Auth::user()->role_id == 1 || Auth::user()->id == $meeting->created_by)
                                        @lang('lang.start')
                                    @else
                                        @lang('lang.join')
                                    @endif
                                </a>
                            @else
                                <button href="#notpermitted" class="primary-btn small bg-warning text-white border-0">Not Permitted</button>
                            @endif

                        @elseif( $meeting->currentStatus == 'waiting')
                            <a href="#Closed" class="primary-btn small bg-info text-white border-0">Waiting</button>
                        @else
                            <a href="#Closed" class="primary-btn small bg-warning text-white border-0">Closed</button>
                        @endif
                    </td>
                    <td>
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                    @lang('lang.select')
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('zoom.meetings.show', $meeting->meeting_id) }}">@lang('lang.view')</a>
                                    @if(userPermission(557))
                                        <a class="dropdown-item" href="{{ route('zoom.meetings.edit',$meeting->id ) }}">@lang('lang.edit')</a>
                                    @endif
                                    @if(Auth::user()->id == $meeting->created_by)
                                    
                                     <a class="dropdown-item modalLink" data-modal-size="modal-md" title="@lang('lang.upload') @lang('lang.recorded') @lang('lang.video')"  
                                           href="{{route('zoom.meeting-upload-vedio-file', [$meeting->id])}}" >@lang('lang.upload') @lang('lang.recorded') @lang('lang.video')</a>
                                  
                                    @endif
                                    @if(userPermission(558))
                                        <a class="dropdown-item" data-toggle="modal" data-target="#d{{$meeting->id}}" href="#">@lang('lang.delete')</a>
                                    @endif
                                </div>
                            </div>
                    </td>
                </tr>
                <div class="modal fade admin-query" id="uploadmeeting{{$meeting->id}}">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> @lang('lang.upload') @lang('lang.recorded')  @lang('lang.file')</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="container-fluid">
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'zoom.upload_document',
                                                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'document_upload']) }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="meeting_id"
                                                   value="{{$meeting->id}}">
                                            <div class="row mt-25">
                                                <div class="col-lg-12">
                                                    <div class="input-effect">
                                                        <input type="hidden" name="meetingupload" value="meetingUpload">
                                                        <input class="primary-input form-control" type="text"
                                                               name="title" value="{{$meeting->vedio_link}}" id="link">
                                                        <label> @lang('lang.link')</label>
                                                        <span class="focus-border"></span>

                                                        <span class=" text-danger" role="alert"
                                                              id="amount_error">
                                                            
                                                        </span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-30">
                                            <div class="row no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="input-effect">
                                                        <input class="primary-input" type="text"
                                                               id="placeholderPhoto" placeholder="{{isset($meeting->local_video) && @$meeting->local_video != ""? getFilePath3(@$meeting->local_video) : 'Attach File'}}"
                                                               disabled>
                                                        <span class="focus-border"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="primary-btn-small-input" type="button">
                                                        <label class="primary-btn small fix-gr-bg" for="photo"> @lang('lang.browse')</label>
                                                        <input type="file" class="d-none" name="vedio"
                                                               id="photo">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 text-center mt-40">
                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg"
                                                        data-dismiss="modal">@lang('lang.cancel')
                                                </button>

                                                <button class="primary-btn fix-gr-bg submit" type="submit">@lang('lang.save')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if(userPermission(558))
                    <div class="modal fade admin-query" id="d{{$meeting->id}}" >
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('lang.delete_meetings')</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4>@lang('lang.are_you_sure_delete')</h4>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                        <form class="" action="{{ route('zoom.meetings.destroy',$meeting->id) }}" method="POST" >
                                            @csrf
                                            @method('delete')
                                            <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
