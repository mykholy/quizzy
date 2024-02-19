<input value="1" name="bulk" hidden="">
<!-- Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('count', __('models/coupons.fields.count').':') !!}
    {!! Form::number('count', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', __('models/coupons.fields.value').':') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>
