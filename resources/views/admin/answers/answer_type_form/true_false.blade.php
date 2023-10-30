<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('models/answers.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>


<!-- 'bootstrap / Toggle Switch is_correct Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_correct', 0) !!}
        {!! Form::checkbox('is_correct', 1, null,  ['id'=>'is_correct','class' => 'custom-control-input']) !!}
        {!! Form::label('is_correct', __('models/answers.fields.is_correct').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>

