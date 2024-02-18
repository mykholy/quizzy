<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/stations.fields.name').':') !!}
    <p>{{ $station->name }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', __('models/stations.fields.latitude').':') !!}
    <p>{{ $station->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', __('models/stations.fields.longitude').':') !!}
    <p>{{ $station->longitude }}</p>
</div>

<!-- Cost Field -->
<div class="col-sm-12">
    {!! Form::label('cost', __('models/stations.fields.cost').':') !!}
    <p>{{ $station->cost }}</p>
</div>

<!-- Cost Description Field -->
<div class="col-sm-12">
    {!! Form::label('cost_description', __('models/stations.fields.cost_description').':') !!}
    <p>{{ $station->cost_description }}</p>
</div>

<!-- Manufacturer Field -->
<div class="col-sm-12">
    {!! Form::label('manufacturer', __('models/stations.fields.manufacturer').':') !!}
    <p>{{ $station->manufacturer }}</p>
</div>

<!-- Model Field -->
<div class="col-sm-12">
    {!! Form::label('model', __('models/stations.fields.model').':') !!}
    <p>{{ $station->model }}</p>
</div>

<!-- Pwps Version Field -->
<div class="col-sm-12">
    {!! Form::label('pwps_version', __('models/stations.fields.pwps_version').':') !!}
    <p>{{ $station->pwps_version }}</p>
</div>

<!-- Qr Enabled Field -->
<div class="col-sm-12">
    {!! Form::label('qr_enabled', __('models/stations.fields.qr_enabled').':') !!}
    <p>
        <span
            class="badge bg-{{$station->qr_enabled?'success':'danger'}}">{{__('lang.'.($station->qr_enabled?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Outlets Field -->
<div class="col-sm-12">
    {!! Form::label('outlets', __('models/stations.fields.outlets').':') !!}
    <p>{{ $station->outlets }}</p>
</div>

<!-- Hours Field -->
<div class="col-sm-12">
    {!! Form::label('hours', __('models/stations.fields.hours').':') !!}
    <p>{{ $station->hours }}</p>
</div>

<!-- Pre Charge Instructions Field -->
<div class="col-sm-12">
    {!! Form::label('pre_charge_instructions', __('models/stations.fields.pre_charge_instructions').':') !!}
    <p>{{ $station->pre_charge_instructions }}</p>
</div>

<!-- Available Field -->
<div class="col-sm-12">
    {!! Form::label('available', __('models/stations.fields.available').':') !!}
    <p>{{ $station->available }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/stations.fields.created_at').':') !!}
    <p>{{ $station->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/stations.fields.updated_at').':') !!}
    <p>{{ $station->updated_at }}</p>
</div>

<!-- Plugshare Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('plugshare_location_id', __('models/stations.fields.plugshare_location_id').':') !!}
    <p>{{ $station->plugshare_location_id }}</p>
</div>

<!-- Plugshare Station Id Field -->
<div class="col-sm-12">
    {!! Form::label('plugshare_station_id', __('models/stations.fields.plugshare_station_id').':') !!}
    <p>{{ $station->plugshare_station_id }}</p>
</div>

