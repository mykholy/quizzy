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


<div class="form-group col-sm-6 col-lg-6 mb-3">
    <!-- answer_img Field -->
    <div class="form-group col-sm-6">
        <h2 class="">{{__('EBook/answers.fields.answer_img')}}</h2>
        <div class="input-group">
                <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white lfm">
                <i class="fa fa-image"></i> {{trans('lang.choose')}}
                </a>
                </span>
            {!! Form::text('answer_img', null, ['hidden'=>'hidden', 'id'=>'thumbnail','class' => 'form-control' . ($errors->has('answer_img')?' is-invalid':'')  ]) !!}
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
    </div>


    @if ($errors->has('answer_img'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_img') }}</small>
         </span>
    @endif

</div>

