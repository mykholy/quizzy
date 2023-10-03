<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/cars.fields.name').':') !!}
    <p>{{ $car->name }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('car_model', __('models/clients.fields.car_model').':') !!}

    <p>
        @foreach(explode(',',$car->tags) as $car_model)
            <span
                class="badge badge-success">{{$car_model}}</span>


        @endforeach
    </p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/cars.fields.photo').':') !!}
    <p><img src="{{ $car->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/cars.fields.is_active').':') !!}

    <p>
        <span class="badge badge-{{$car->is_active?'success':'danger'}}">{{__('lang.'.($car->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/cars.fields.created_at').':') !!}
    <p>{{ $car->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/cars.fields.updated_at').':') !!}
    <p>{{ $car->updated_at }}</p>
</div>

