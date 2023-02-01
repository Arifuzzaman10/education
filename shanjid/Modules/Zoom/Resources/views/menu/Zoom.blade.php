
@if(userPermission(554) && menuStatus(554))
    <li data-position="{{menuPosition(554)}}" class="sortable_li">
        <a href="#zoomMenu" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
            <span class="flaticon-reading"></span>
        @lang('lang.virtual_class')
        </a>
        <ul class="collapse list-unstyled" id="zoomMenu">
            @if(userPermission(555) && menuStatus(555))
                <li data-position="{{menuPosition(555)}}">
                    <a href="{{ route('zoom.virtual-class')}}">@lang('lang.virtual_class')</a>
                </li>
            @endif
            @if(userPermission(560) && menuStatus(560))
                <li data-position="{{menuPosition(560)}}">
                    <a href="{{ route('zoom.meetings') }}">@lang('lang.virtual_meeting')</a>
                </li>
            @endif
            @if(userPermission(565) && menuStatus(565))
                <li data-position="{{menuPosition(565)}}">
                    <a href="{{ route('zoom.virtual.class.reports.show') }}">@lang('lang.class_reports')</a>
                </li>
            @endif
            {{-- @if(userPermission(565) && menuStatus(565))
            <li data-position="{{menuPosition(565)}}">
                <a href="{{ route('zoom.virtual.class.reports.show') }}">@lang('lang.Recorder') @lang('lang.file')</a>
            </li>
            @endif --}}


            @if(userPermission(567) && menuStatus(567))
                <li data-position="{{menuPosition(567)}}">
                    <a href="{{ route('zoom.meeting.reports.show') }}">@lang('lang.meeting_reports')</a>
                </li>
            @endif
            @if(userPermission(569) && menuStatus(569))
                <li data-position="{{menuPosition(569)}}">
                    <a href="{{ route('zoom.settings') }}">@lang('lang.settings')</a>
                </li>
            @endif
        </ul>
    </li>
    <!-- Zoom Menu  -->
@endif
