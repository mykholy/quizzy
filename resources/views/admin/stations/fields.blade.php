<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/stations.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', __('models/stations.fields.latitude').':') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', __('models/stations.fields.longitude').':') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Cost Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost', __('models/stations.fields.cost').':') !!}
    {!! Form::text('cost', null, ['class' => 'form-control']) !!}
</div>

<!-- Cost Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cost_description', __('models/stations.fields.cost_description').':') !!}
    {!! Form::text('cost_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Manufacturer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manufacturer', __('models/stations.fields.manufacturer').':') !!}
    {!! Form::text('manufacturer', null, ['class' => 'form-control']) !!}
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', __('models/stations.fields.model').':') !!}
    {!! Form::text('model', null, ['class' => 'form-control']) !!}
</div>

<!-- Pwps Version Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pwps_version', __('models/stations.fields.pwps_version').':') !!}
    {!! Form::text('pwps_version', null, ['class' => 'form-control']) !!}
</div>

<!-- Location id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', __('models/stations.fields.location_id').':') !!}
    {!! Form::select('location_id', \App\Models\Admin\Location::pluck('name','id')->toArray(), request('location_id'), ['class' => 'form-control form-select '. ($errors->has('location_id')?' is-invalid ':'')]) !!}

    @if ($errors->has('location_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('amenity_ids') }}</small>

             </span>
    @endif
</div>

<!-- 'bootstrap / Toggle Switch Qr Enabled Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('qr_enabled', 0) !!}
        {!! Form::checkbox('qr_enabled', 1, null,  ['id'=>'qr_enabled','class' => 'custom-control-input']) !!}
        {!! Form::label('qr_enabled', __('models/stations.fields.qr_enabled').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>




<!-- Hours Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hours', __('models/stations.fields.hours').':') !!}
    {!! Form::text('hours', null, ['class' => 'form-control']) !!}
</div>

<!-- Pre Charge Instructions Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pre_charge_instructions', __('models/stations.fields.pre_charge_instructions').':') !!}
    {!! Form::text('pre_charge_instructions', null, ['class' => 'form-control']) !!}
</div>

<!-- Available Field -->
<div class="form-group col-sm-6">
    {!! Form::label('available', __('models/stations.fields.available').':') !!}
    {!! Form::select('available', ['0' => 'Unknown', '1' => 'Available', '2' => 'In Use', '3' => 'Offline', '4' => 'Under Repair'], null, ['class' => 'form-control custom-select']) !!}
</div>

<div class="outlets-list-repeater col-sm-12 col-lg-12 mb-3">
    <h2>{{ __('models/stations.fields.outlets')}}:</h2>
    <div data-repeater-list="outlets">
        <div data-repeater-item>
            <div class="row d-flex align-items-end">
                <div class="col-md-2 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="available">{{trans('models/stations.available')}}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="available"
                            name="available"
                            aria-describedby="available"
                            placeholder=""
                        />
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="kilowatts">{{trans('models/stations.kilowatts')}}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="kilowatts"
                            name="kilowatts"
                            aria-describedby="kilowatts"
                            placeholder=""
                        />
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="power">{{trans('models/stations.power')}}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="power"
                            name="power"
                            aria-describedby="power"
                            placeholder=""
                        />
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="connector_id">{{trans('models/stations.connector_id')}}</label>

                        {!! Form::select('connector_id', \App\Models\Admin\Connector::pluck('name','id')->toArray(), null, ['id'=>'connector_id','class' => 'form-control form-select '. ($errors->has('connector_id')?' is-invalid ':'')]) !!}

                    </div>
                </div>

                <div class="col-md-2 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="status">{{trans('models/stations.status')}}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="status"
                            name="status"
                            aria-describedby="status"
                            placeholder=""
                        />
                    </div>
                </div>

                <div class="col-md-2 col-12 mb-50">
                    <div class="mb-1">
                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                            <i data-feather="x" class="me-25"></i>
                            <span>{{trans('lang.delete')}}</span>
                        </button>
                    </div>
                </div>
            </div>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                <i data-feather="plus" class="me-25"></i>
                <span>{{trans('lang.add_new')}}</span>
            </button>
        </div>
    </div>
</div>

<!-- Plugshare Location Id Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('plugshare_location_id', __('models/stations.fields.plugshare_location_id').':') !!}--}}
{{--    {!! Form::text('plugshare_location_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Plugshare Station Id Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('plugshare_station_id', __('models/stations.fields.plugshare_station_id').':') !!}--}}
{{--    {!! Form::text('plugshare_station_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}
@push('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Start repeater -->
    <script src="{{asset('repeater/jquery.repeater.min.js')}}"></script>
    <!-- End repeater -->

    <script>
        // form repeater jquery
        repeater = $('.outlets-list-repeater, .repeater-default').repeater({
            show: function () {
                $(this).slideDown();
                // Feather Icons

            },
            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        @if(isset($station->outlets))
        repeater.setList({!! ($station->outlets) !!});
        @endif

    </script>
@endpush
