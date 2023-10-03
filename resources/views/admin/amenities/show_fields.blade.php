<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/amenities.fields.name').':') !!}
    <p>{{ $amenity->name }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/amenities.fields.photo').':') !!}
        <p><img src="{{ $amenity->photo }}" width="200px" height="200px" /></p>

</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/amenities.fields.is_active').':') !!}
   <p>
        <span class="badge badge-{{$amenity->is_active?'success':'danger'}}">{{__('lang.'.($amenity->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/amenities.fields.created_at').':') !!}
    <p>{{ $amenity->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/amenities.fields.updated_at').':') !!}
    <p>{{ $amenity->updated_at }}</p>
</div>

