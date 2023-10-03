<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/clients.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('models/clients.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 255]) !!}
</div>

<!-- password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('models/clients.fields.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control', 'minlength' => 6]) !!}
</div>

<!-- Car id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('car_id', __('models/clients.fields.car_id').':') !!}
    {!! Form::select('car_id', \App\Models\Admin\Car::pluck('name','id')->toArray(), null, ['class' => 'form-control form-select '. ($errors->has('car_id')?' is-invalid ':'')]) !!}

    @if ($errors->has('car_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('car_id') }}</small>

             </span>
    @endif
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/clients.fields.photo').':') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('photo', ['class' => 'custom-file-input']) !!}
            {!! Form::label('photo', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/clients.fields.is_active').':', ['class' => 'custom-control-label']) !!}
    </div>

</div>
