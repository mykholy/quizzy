<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', __('models/ads.fields.title').':') !!}
    <p>{{ $ad->title }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/ads.fields.photo').':') !!}
    <p>{{ $ad->photo }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/ads.fields.is_active').':') !!}
    <p>{{ $ad->is_active }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/ads.fields.created_at').':') !!}
    <p>{{ $ad->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/ads.fields.updated_at').':') !!}
    <p>{{ $ad->updated_at }}</p>
</div>

