<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('EBook/answers.fields.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>

<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('answer_two_gap_match', __('EBook/answers.correct_answers').'*') !!}

    {!! Form::text('answer_two_gap_match',null, array('placeholder' => '','class' => 'form-control','required'=>'')) !!}
    <small><i class="fa fa-info-circle"></i> {{trans('EBook/answers.correct_answers_info')}}</small>

</div>

