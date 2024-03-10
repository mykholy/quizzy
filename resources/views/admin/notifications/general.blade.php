<!-- title Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('title', __('models/fields.notifications.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control  '. ($errors->has('title')?' is-invalid ':'')]) !!}

    @if ($errors->has('title'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('title') }}</small>

        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('body', __('models/fields.notifications.body').':') !!}
    {!! Form::text('body', null, ['class' => 'form-control  '. ($errors->has('body')?' is-invalid ':'')]) !!}

    @if ($errors->has('body'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('body') }}</small>

        </span>
    @endif
</div>

<!-- Submit Field -->
<div class="btn-showcase mt-5">
    {!! Form::submit(ucfirst(__('lang.save')), ['class' => 'btn btn-primary']) !!}
    <input class="btn btn-light" type="reset" value="{{ucfirst(__('lang.reset'))}}">
</div>
