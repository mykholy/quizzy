<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/students.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('models/students.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'minlength' => 3, 'maxlength' => 255]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', __('models/students.fields.phone').':') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'minlength' => 6, 'maxlength' => 20]) !!}
</div>

<!-- password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('models/students.fields.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control', 'minlength' => 6]) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/students.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/students.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>
