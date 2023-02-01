
@if(Auth::user()->role_id == 1 )
    <div class="col-lg-9">
@elseif(userPermission(555) && userPermission(556))
    <div class="col-lg-9">
@else
    <div class="col-lg-12">
@endif
        <div class="main-title">
            <h3 class="mb-0">
                @lang('lang.virtual_class')  @lang('lang.list')
            </h3>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if (Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
                                <th>@lang('lang.class')</th>
                                <th>@lang('lang.class_section')</th>
                            @endif
                            <th>@lang('lang.virtual_class_id')</th>
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
                            @if (Auth::user()->role_id != 2 || Auth::user()->role_id != 3 )
                                <td>{{ $meeting->class->class_name }}</td>
                                <td>{{ $meeting->section_id !=null ?  $meeting->section->section_name :'All sections' }}</td>
                            @endif
                            <td>{{ $meeting->meeting_id }}</td>
                            <td>{{ $meeting->password }}</td>
                            <td>{{ $meeting->topic }}</td>
                            <td>{{ $meeting->date_of_meeting }}</td>
                            <td>{{ $meeting->time_of_meeting }}</td>
                            <td>{{ $meeting->meeting_duration }} @lang('lang.min')</td>
                            <td>{{ $meeting->time_before_start }} Min </td>
                            <td>
                                @if($meeting->currentStatus == 'started')
                           
                                        <a class="primary-btn small bg-success text-white border-0" href="{{ route('zoom.virtual-class.join', $meeting->meeting_id) }}" target="_blank" >
                                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->id == $meeting->created_by )
                                                @lang('lang.start')
                                            @else
                                                @lang('lang.join')
                                            @endif
                                        </a>
            
                                @elseif( $meeting->currentStatus == 'waiting')
                                    <a href="#Closed" class="primary-btn small bg-info text-white border-0">@lang('lang.waiting')</button>
                                @else
                                    <a href="#Closed" class="primary-btn small bg-warning text-white border-0">@lang('lang.closed')</button>
                                @endif
                                
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('lang.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" target="_blank"  href="{{ route('zoom.virtual-class.show', $meeting->meeting_id) }}">@lang('lang.view')</a>
                                         @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->id == $meeting->created_by )
                                         
                                         
                                           <a class="dropdown-item modalLink" data-modal-size="modal-md"   title="@lang('lang.upload') @lang('lang.recorded') @lang('lang.video')"  
                                           href="{{route('zoom.virtual-upload-vedio-file', [$meeting->id])}}" >@lang('lang.upload') @lang('lang.recorded') @lang('lang.video')</a>
                                        
                                        @endif
                                        @if(userPermission(562))
                                            <a class="dropdown-item" href="{{ route('zoom.virtual-class.edit',$meeting->id ) }}">@lang('lang.edit')</a>
                                        @endif
                                        @if(userPermission(563) )
                                            <a class="dropdown-item" data-toggle="modal" data-target="#d{{$meeting->id}}" href="#">@lang('lang.delete')</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
     
                   
                        @if(userPermission(563))
                            <div class="modal fade admin-query" id="d{{$meeting->id}}" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('lang.delete_virtual_class')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <h4>@lang('lang.are_you_sure_delete')</h4>
                                            </div>
                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                <form class="" action="{{ route('zoom.virtual-class.destroy',$meeting->id) }}" method="POST" >
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
