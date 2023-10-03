<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/clients.fields.name').':') !!}
    <p>{{ $client->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', __('models/clients.fields.email').':') !!}
    <p>{{ $client->email }}</p>
</div>

<!-- phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', __('models/clients.fields.phone').':') !!}
    <p>{{ $client->phone }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('car', __('models/clients.fields.car_id').':') !!}
    <p>{{ optional($client->car)->name }}</p>
</div>
<div class="col-sm-12">
    {!! Form::label('car_model', __('models/clients.fields.car_model').':') !!}
    <p>{{$client->car_model }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/clients.fields.photo').':') !!}
    <p><img src="{{ $client->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/clients.fields.is_active').':') !!}
    <p>
        <span class="badge badge-{{$client->is_active?'success':'danger'}}">{{__('lang.'.($client->is_active?'active':'not_active'))}}</span>

    </p>

</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/clients.fields.created_at').':') !!}
    <p>{{ $client->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/clients.fields.updated_at').':') !!}
    <p>{{ $client->updated_at }}</p>
</div>

