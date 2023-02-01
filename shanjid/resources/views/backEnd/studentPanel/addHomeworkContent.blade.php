<script src="{{asset('public/backEnd/')}}/js/custom.js"></script>
<div class="modal-body">
                                        <div class="container-fluid">
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'upload-homework-content',
                                                                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                                <input type="hidden" name="id" value="{{$homework_id}}">
                                            <div class="row">
                                                <div class="col-lg-12 mt-30">
                                                    <div class="row no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="input-effect">
                                                                <input class="primary-input" type="text"
                                                                       id="placeholderPhoto" placeholder="Document"
                                                                       disabled>
                                                                <span class="focus-border"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="primary-btn-small-input" type="button">
                                                                <label class="primary-btn small fix-gr-bg" for="photo"> @lang('common.browse')</label>
                                                                <input type="file" multiple class="d-none" name="files[]"
                                                                       id="photo">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-12 text-center mt-40">
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg submit"
                                                                data-dismiss="modal">@lang('common.cancel')
                                                        </button>

                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.save')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>