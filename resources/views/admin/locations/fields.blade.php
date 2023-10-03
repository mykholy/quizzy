<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/locations.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/locations.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', __('models/locations.fields.latitude').':') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', __('models/locations.fields.longitude').':') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
</div>


<!-- Photos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photos', __('models/locations.fields.photos').':') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('photos[]', ['multiple'=>'multiple','class' => 'custom-file-input']) !!}
            {!! Form::label('photos', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
    @if(isset($location->photos))
        <div class="my-2">
            @foreach(json_decode($location->photos) as $photo)
                <img  width="100px" height="100px" src="{{asset($photo)}}" alt="">
            @endforeach
        </div>
    @endif
</div>
<div class="clearfix"></div>


<!-- Score Field -->
<div class="form-group col-sm-6">
    {!! Form::label('score', __('models/locations.fields.score').':') !!}
    {!! Form::text('score', null, ['class' => 'form-control']) !!}
</div>

<!-- 'bootstrap / Toggle Switch Cost Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('cost', 0) !!}
        {!! Form::checkbox('cost', 1, null,  ['id'=>'cost','class' => 'custom-control-input']) !!}
        {!! Form::label('cost', __('models/locations.fields.cost').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>


<!-- Cost Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost_description', __('models/locations.fields.cost_description').':') !!}
    {!! Form::text('cost_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Access Field -->
<div class="form-group col-sm-6">
    {!! Form::label('access', __('models/locations.fields.access').':') !!}
    {!! Form::number('access', null, ['class' => 'form-control']) !!}
</div>

<!-- Icon Field -->
<div class="form-group col-sm-6">
    {!! Form::label('icon', __('models/locations.fields.icon').':') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('icon', ['class' => 'custom-file-input']) !!}
            {!! Form::label('icon', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Icon Type Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('icon_type', __('models/locations.fields.icon_type').':') !!}--}}
{{--    {!! Form::text('icon_type', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', __('models/locations.fields.phone').':') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', __('models/locations.fields.address').':') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Pwps Version Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('pwps_version', __('models/locations.fields.pwps_version').':') !!}--}}
{{--    {!! Form::text('pwps_version', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}




<!-- Poi Name Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('poi_name', __('models/locations.fields.poi_name').':') !!}--}}
{{--    {!! Form::text('poi_name', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Parking Type Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parking_type_name', __('models/locations.fields.parking_type_name').':') !!}
    {!! Form::text('parking_type_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Locale Field -->
<div class="form-group col-sm-6">
    {!! Form::label('locale', __('models/locations.fields.locale').':') !!}
    {!! Form::text('locale', null, ['class' => 'form-control']) !!}
</div>

<!-- Opening Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('opening_date', __('models/locations.fields.opening_date').':') !!}
    {!! Form::date('opening_date', null, ['class' => 'form-control','id'=>'opening_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#opening_date').datepicker()
    </script>
@endpush

<!-- Hours Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hours', __('models/locations.fields.hours').':') !!}
    {!! Form::text('hours', null, ['class' => 'form-control']) !!}
</div>

<!-- Access Restrictions Field -->
<div class="form-group col-sm-6">
    {!! Form::label('access_restrictions', __('models/locations.fields.access_restrictions').':') !!}
    {!! Form::select('access_restrictions', ['CUSTOMERS_ONLY' => 'CUSTOMERS_ONLY', 'GUESTS_ONLY' => 'GUESTS_ONLY', 'EMPLOYEES_ONLY' => 'EMPLOYEES_ONLY', 'STUDENTS_ONLY' => 'STUDENTS_ONLY', 'RESIDENTS_ONLY' => 'RESIDENTS_ONLY'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Parking Attributes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parking_attributes', __('models/locations.fields.parking_attributes').':') !!}
    {!! Form::select('parking_attributes', ['PULL_THROUGH' => 'PULL_THROUGH', 'PULL_IN' => 'PULL_IN', 'TRAILER_PARKING' => 'TRAILER_PARKING', 'TRAILER_FRIENDLY' => 'TRAILER_FRIENDLY', 'GARAGE' => 'GARAGE', 'HANDICAPPED' => 'HANDICAPPED', 'WHEELCHAIR_ACCESS' => 'WHEELCHAIR_ACCESS', 'ILLUMINATED' => 'ILLUMINATED'], null, ['class' => 'form-control custom-select']) !!}
</div>

{{--region_id--}}
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('amenity_ids', __('models/locations.fields.amenity_ids').':') !!}
    {!! Form::select('amenity_ids[]', \App\Models\Admin\Amenity::pluck('name','id')->toArray(), isset($location)?$location->amenities->pluck('id')->toArray():null, ['multiple'=>'multiple','class' => 'form-control form-select '. ($errors->has('amenity_ids')?' is-invalid ':'')]) !!}

    @if ($errors->has('amenity_ids'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('amenity_ids') }}</small>

             </span>
    @endif
</div>

<!-- Parking Level Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parking_level', __('models/locations.fields.parking_level').':') !!}
    {!! Form::text('parking_level', null, ['class' => 'form-control']) !!}
</div>

<!-- Overhead Clearance Meters Field -->
<div class="form-group col-sm-6">
    {!! Form::label('overhead_clearance_meters', __('models/locations.fields.overhead_clearance_meters').':') !!}
    {!! Form::text('overhead_clearance_meters', null, ['class' => 'form-control']) !!}
</div>

<!-- 'bootstrap / Toggle Switch Qr Enabled Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('qr_enabled', 0) !!}
        {!! Form::checkbox('qr_enabled', 1, null,  ['id'=>'qr_enabled','class' => 'custom-control-input']) !!}
        {!! Form::label('qr_enabled', __('models/locations.fields.qr_enabled').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>

<!-- 'bootstrap / Toggle Switch Open247 Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('open247', 0) !!}
        {!! Form::checkbox('open247', 1, null,  ['id'=>'open247','class' => 'custom-control-input']) !!}
        {!! Form::label('open247', __('models/locations.fields.open247').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>


<!-- 'bootstrap / Toggle Switch Coming Soon Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('coming_soon', 0) !!}
        {!! Form::checkbox('coming_soon', 1, null,  ['id'=>'coming_soon','class' => 'custom-control-input']) !!}
        {!! Form::label('coming_soon', __('models/locations.fields.coming_soon').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>


<!-- 'bootstrap / Toggle Switch Under Repair Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('under_repair', 0) !!}
        {!! Form::checkbox('under_repair', 1, null,  ['id'=>'under_repair','class' => 'custom-control-input']) !!}
        {!! Form::label('under_repair', __('models/locations.fields.under_repair').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>


<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/clients.fields.is_active').':', ['class' => 'custom-control-label']) !!}
    </div>

</div>

<!-- Plugshare Location Id Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('plugshare_location_id', __('models/locations.fields.plugshare_location_id').':') !!}--}}
{{--    {!! Form::text('plugshare_location_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}
