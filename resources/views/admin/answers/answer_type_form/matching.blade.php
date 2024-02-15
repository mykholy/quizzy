<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('models/answers.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>

<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('answer_two_gap_match', __('models/answers.matched_answer_title')) !!}
    {!! Form::text('answer_two_gap_match', null, ['class' => 'form-control' . ($errors->has('answer_two_gap_match')?' is-invalid':'')  ]) !!}
    @if ($errors->has('answer_two_gap_match'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_two_gap_match') }}</small>
         </span>
    @endif
</div>


<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('answer_two_gap_match', __('models/answers.answer_view_format')) !!}

    {!! Form::select('answer_view_format',App\Models\Admin\Answer::getAllAnswerViewFormat(),null, array('class' => 'form-control select2 select2-hidden-accessible','required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}
    @if ($errors->has('answer_view_format'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_view_format') }}</small>

         </span>
    @endif


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



