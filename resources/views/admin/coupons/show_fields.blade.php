<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', __('models/coupons.fields.title').':') !!}
    <p>{{ $coupon->title }}</p>
</div>

<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', __('models/coupons.fields.code').':') !!}
    <p>{{ $coupon->code }}</p>
</div>

<!-- Value Field -->
<div class="col-sm-12">
    {!! Form::label('value', __('models/coupons.fields.value').':') !!}
    <p>{{ $coupon->value }}</p>

</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/coupons.fields.is_active').':') !!}
    <p>
        <span class="badge bg-{{$coupon->is_active?'success':'danger'}}">{{__('lang.'.($coupon->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/coupons.fields.created_at').':') !!}
    <p>{{ $coupon->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/coupons.fields.updated_at').':') !!}
    <p>{{ $coupon->updated_at }}</p>
</div>

