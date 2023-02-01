@extends('backEnd.master')
@section('title')
    @lang('chat::chat.create_group')
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor" id="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="chat_main_wrapper">
                        <div class="chat_flow_list_wrapper ">
                            <div class="box_header">
                                <div class="main-title">
                                    <h3 class="m-0">@lang('chat::chat.chat_list')</h3>
                                </div>
                                @if(userPermission(902))
                                    <a class="primary-btn radius_30px  fix-gr-bg" href="{{ route('chat.new') }}"><i class="ti-plus"></i>@lang('chat::chat.new_chat')</a>
                                @endif
                            </div>
                            <!-- chat_list  -->
                            <side-panel-component
                                    :settings="{{ json_encode(generalSetting()->only(['teacher_phone_view', 'teacher_email_view'])) }}"
                                    :search_url="{{ json_encode(route('chat.user.search')) }}"
                                    :single_chat_url="{{ json_encode(route('chat.index')) }}"
                                    :chat_block_url="{{ json_encode(route('chat.user.block')) }}"
                                    :create_group_url="{{ json_encode(route('chat.group.create')) }}"
                                    :group_chat_show="{{ json_encode(route('chat.group.show')) }}"
                                    :users="{{ json_encode($users) }}"
                                    :groups="{{ json_encode($myGroups) }}"
                                    :all_users="{{ json_encode(\App\Models\User::where('id', '!=', auth()->id())->get()) }}"
                                    :can_create_group="{{ json_encode(createGroupPermission())}}"
                                    :asset_type="{{ json_encode('/public') }}"
                            ></side-panel-component>
                        </div>
                        <div class="chat_view_list ">
                            <div class="box_header">
                                <div class="main-title">
                                    <h3 class="m-0">@lang('chat::chat.create_group')</h3>
                                </div>
                            </div>
                            <div class="chat_view_list_inner crm_full_height ">
                                <form action="{{ route('chat.group.create') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="chat_view_list_inner_scrolled" style="overflow: unset;">
                                        <div class="primary_input mb_20">
                                            <label class="primary_input_label" for="">@lang('chat::chat.group_name') *</label>
                                            <input class="primary_input_field" placeholder="-" type="text" name="name" required>
                                        </div>
                                        <div class="primary_input mb_20 mt-5">
                                            <div class="row no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                                        <input class="primary-input" type="text" id="placeholderGroupPhoto" placeholder="@lang('chat::chat.group_photo')" readonly="">
                                                        <span class="focus-border"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <button class="primary-btn-small-input" type="button">
                                                        <label class="primary-btn small fix-gr-bg" for="group_photo">@lang('common.browse')</label>
                                                        <input type="file" class="d-none" name="group_photo" id="group_photo">
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                                        </div>
                                        <div class="primary_input mb-15 mt-5">
                                            <label class="primary_input_label" for="">@lang('common.member') *</label>
                                            <select class="primary_selet select_users mb-25" name="users[]" id="" multiple required>
                                                @foreach ($users as $key => $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="primary-btn radius_30px  fix-gr-bg" href="#">@lang('chat::chat.create_group')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('.select_users').select2();
    </script>
@endpush