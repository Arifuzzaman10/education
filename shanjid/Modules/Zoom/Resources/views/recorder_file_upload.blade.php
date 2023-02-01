<style>
    .paddinfTop{
        padding-top:-10px;
    }
</style>
<div class="container-fluid">
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'zoom.upload_document',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'myForm', 'onsubmit' => "return validateFormFees()"]) }}
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="meetingupload"     value="{{$uploadtype}}">
                   <input type="hidden" name="meeting_id"     value="{{$meeting->id}}">
                          <div class="row mt-25">
                                <div class="col-lg-12">
                                       <div class="input-effect">
                                            <input class="primary-input form-control" type="text" name="link" value="{{$meeting->vedio_link != "" ? $meeting->vedio_link :''}}">
                                                    <label class="paddinfTop"> @lang('lang.link')</label>
                                                        <span class="focus-border"></span>
                                                                <span class=" text-danger" role="alert" id="amount_error">
                                                                    
                                                                </span>
                                       </div>
                                </div>
                       </div>





                <div class="row no-gutters input-right-icon mt-35">
                        <div class="col">
                            <div class="input-effect">
                                <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" 
                                id="placeholderInput" 
                                type="text"
                                placeholder="{{isset($meeting->local_video) && @$meeting->local_video != ""? getFilePath3(@$meeting->local_video):'File Name'}}"
                                readonly>
                                <span class="focus-border"></span>

                                @if ($errors->has('file'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ @$errors->first('file') }}</strong>
                                    </span>
                            @endif
                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg"
                                       for="browseFile">@lang('lang.browse')</label>
                                <input type="file" class="d-none" id="browseFile" name="vedio">
                            </button>
                        </div>
                </div>
            </div>



            <div class="col-lg-12 text-center mt-40">
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>

                    <button class="primary-btn fix-gr-bg submit" type="submit">@lang('lang.save')</button>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>

<script type="text/javascript">


    var fileInput = document.getElementById("browseFile");
    if (fileInput) {
        fileInput.addEventListener("change", showFileName);

        function showFileName(event) {
            var fileInput = event.srcElement;
            var fileName = fileInput.files[0].name;
            document.getElementById("placeholderInput").placeholder = fileName;
        }
    }
    var fileInp = document.getElementById("browseFil");
    if (fileInp) {
        fileInp.addEventListener("change", showFileName);

        function showFileName(event) {
            var fileInp = event.srcElement;
            var fileName = fileInp.files[0].name;
            document.getElementById("placeholderIn").placeholder = fileName;
        }
    }

    if ($(".niceSelect1").length) {
        $(".niceSelect1").niceSelect();
    }



</script>
