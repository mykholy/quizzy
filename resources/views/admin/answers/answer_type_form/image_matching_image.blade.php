<div class="form-group row">
    <label
        class="col-sm-2 form-control-label">{!!  __('backend.image_matched_image') !!}
    </label>
    <div class="col-sm-10">
        {!! Form::file('title',['accept'=>'.jpg, .png, image/jpeg, image/png','data-default-file'=>(isset($answer->title)? URL::to('uploads/answers/'.$answer->title):''),'data-plugins'=>"dropify", 'data-height'=>'150','class' => 'form-control dropify  ']) !!}
    </div>
</div>




<div class="form-group row">
    <!-- answer_img Field -->
    <div class="form-group row">
        {!! Form::label('answer_img', __('backend.answer_img'),["class"=>"col-sm-2 form-control-label"]) !!}
        <div class="col-sm-10">
            {!! Form::file('answer_img',['accept'=>'.jpg, .png, image/jpeg, image/png','data-default-file'=>(isset($answer->answer_img)? URL::to('uploads/answers/'.$answer->answer_img):''),'data-plugins'=>"dropify", 'data-height'=>'150','class' => 'form-control dropify  ']) !!}
        </div>
    </div>

    @if ($errors->has('answer_img'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_img') }}</small>
         </span>
    @endif

</div>



