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





