<div class="row">
    <!-- contact_address Field -->
    <div class="form-group col-sm-12 col-lg-12 mb-3">
        {!! Form::label('contact_address_'.request('lang_id',1), __('models/settings.general.Address').':') !!}
        {!! Form::text('contact_address_'.request('lang_id',1), setting('contact_address_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('contact_address_'.request('lang_id',1))?' is-invalid ':'')]) !!}

        @if ($errors->has('contact_address_'.request('lang_id',1)))
            <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('contact_address_'.request('lang_id',1)) }}</small>

        </span>
        @endif
    </div>

    <!-- contact_email Field -->
    <div class="form-group col-sm-12 col-lg-12 mb-3">
        {!! Form::label('contact_email_'.request('lang_id',1), __('models/settings.general.Email').':') !!}
        {!! Form::email('contact_email_'.request('lang_id',1), setting('contact_email_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('contact_email_'.request('lang_id',1))?' is-invalid ':'')]) !!}

        @if ($errors->has('contact_email_'.request('lang_id',1)))
            <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('contact_email_'.request('lang_id',1)) }}</small>

        </span>
        @endif
    </div>

    <!-- contact_phone Field -->
    <div class="form-group col-sm-12 col-lg-12 mb-3">
        {!! Form::label('contact_phone_'.request('lang_id',1), __('models/settings.general.Phone').':') !!}
        {!! Form::text('contact_phone_'.request('lang_id',1), setting('contact_phone_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('contact_phone_'.request('lang_id',1))?' is-invalid ':'')]) !!}

        @if ($errors->has('contact_phone_'.request('lang_id',1)))
            <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('contact_phone_'.request('lang_id',1)) }}</small>

        </span>
        @endif
    </div>

    <!-- latitude Field -->
    <div class="form-group col-sm-12 col-lg-6 mb-3">
        {!! Form::label('latitude', __('models/settings.general.latitude').':') !!}
        {!! Form::text('latitude', setting('latitude',null), ['class' => 'form-control  '. ($errors->has('latitude')?' is-invalid ':'')]) !!}

        @if ($errors->has('latitude'))
            <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('latitude') }}</small>

        </span>
        @endif
    </div>

    <!-- Longitude Field -->
    <div class="form-group col-sm-12 col-lg-6 mb-3">
        {!! Form::label('longitude', __('models/settings.general.longitude').':') !!}
        {!! Form::text('longitude', setting('longitude',null), ['class' => 'form-control  '. ($errors->has('longitude')?' is-invalid ':'')]) !!}

        @if ($errors->has('longitude'))
            <span class="invalid-feedback">
                <small
                    class="text-danger">{{ $errors->first('longitude') }}</small>

        </span>
        @endif
    </div>

</div>


