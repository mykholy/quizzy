<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('models/coupons.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', __('models/coupons.fields.code').':') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', __('models/coupons.fields.value').':') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>
