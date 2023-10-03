<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/connectors.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/connectors.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Power Field -->
<div class="form-group col-sm-6">
    {!! Form::label('power', __('models/connectors.fields.power').':') !!}
    {!! Form::text('power', null, ['class' => 'form-control']) !!}
</div>



<!-- Kilowatts Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kilowatts', __('models/connectors.fields.kilowatts').':') !!}
    {!! Form::text('kilowatts', null, ['class' => 'form-control']) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/connectors.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/connectors.fields.is_active').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>
