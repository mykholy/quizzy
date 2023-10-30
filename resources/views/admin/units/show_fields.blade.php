<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/units.fields.name').':') !!}
    <p>{{ $unit->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/units.fields.description').':') !!}
    <p>{{ $unit->description }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/units.fields.photo').':') !!}

    <p><img src="{{ $unit->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/units.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$unit->is_active?'success':'danger'}}">{{__('lang.'.($unit->is_active?'active':'not_active'))}}</span>

    </p>
</div>



<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/units.fields.created_at').':') !!}
    <p>{{ $unit->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/units.fields.updated_at').':') !!}
    <p>{{ $unit->updated_at }}</p>
</div>

