<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('EBook/answers.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>
<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('answer_view_format', __('EBook/answers.answer_view_format')) !!}

    {!! Form::select('answer_view_format',App\Models\EBook\Answer::getAllAnswerViewFormat(),null, array('class' => 'form-control select2 select2-hidden-accessible','required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}
    @if ($errors->has('answer_view_format'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_view_format') }}</small>

         </span>
    @endif


</div>
<!-- image Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    <h2 class="">{{ trans('EBook/answers.fields.answer_img') }}</h2>
    <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                           class="btn btn-primary text-white lfm">
                            <i class="fa fa-image"></i> {{ trans('lang.choose') }}
                        </a>
                    </span>
        {!! Form::text('answer_img', null, [
            'hidden' => 'hidden',
            'id' => 'thumbnail',
            'class' => 'form-control' . ($errors->has('answer_img') ? ' is-invalid' : ''),
        ]) !!}
    </div>
    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
</div>

@push('vendor-scripts')

    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>


    <script>
        var route_prefix = "/admin/laravel-filemanager";
        $('#lfm').filemanager('image', {
            prefix: route_prefix
        });
    </script>

@endpush


<!-- 'bootstrap / Toggle Switch is_correct Field' -->
<div class="row mt-2">
    <!-- status Field -->
    <div class="form-group col-sm-12 mb-3">
        {!! Form::label('is_correct', __('EBook/answers.is_correct')) !!}
        <div class="custom-control custom-switch custom-control-inline">
            {!! Form::hidden("is_correct", 0) !!}
            {!! Form::checkbox("is_correct", 1, null,  ['id'=>"customSwitch2",'class' => 'custom-control-input']) !!}
            <label class="custom-control-label" for="customSwitch2"></label>
        </div>
        @if ($errors->has("is_correct"))
            <span class="invalid-feedback">
                <small class="text-danger">{{ $errors->first("is_correct") }}</small>

             </span>
        @endif
    </div>

</div>




