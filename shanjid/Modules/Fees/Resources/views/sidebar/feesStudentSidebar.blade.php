@if(auth()->user()->student)
    @if(userPermission(1156) && menuStatus(1156))
        <li data-position="{{menuPosition(1156)}}" class="sortable_li">
            <a href="{{route('fees.student-fees-list',[auth()->user()->student->id])}}">
                <div class="nav_icon_small">
                    <span class="flaticon-wallet"></span>
                </div>
                <div class="nav_title">
                    @lang('fees.fees')
                </div>
            </a>
        </li>
    @endif
@endif