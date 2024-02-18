<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/connectors.fields.name').':') !!}
    <p>{{ $connector->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/connectors.fields.description').':') !!}
    <p>{{ $connector->description }}</p>
</div>

<!-- Power Field -->
<div class="col-sm-12">
    {!! Form::label('power', __('models/connectors.fields.power').':') !!}
    <p>{{ $connector->power }}</p>
</div>



<!-- Kilowatts Field -->
<div class="col-sm-12">
    {!! Form::label('kilowatts', __('models/connectors.fields.kilowatts').':') !!}
    <p>{{ $connector->kilowatts }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/connectors.fields.photo').':') !!}

    <p><img src="{{ $connector->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/connectors.fields.is_active').':') !!}
    <p>
        <span class="badge bg-{{$connector->is_active?'success':'danger'}}">{{__('lang.'.($connector->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/connectors.fields.created_at').':') !!}
    <p>{{ $connector->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/connectors.fields.updated_at').':') !!}
    <p>{{ $connector->updated_at }}</p>
</div>

