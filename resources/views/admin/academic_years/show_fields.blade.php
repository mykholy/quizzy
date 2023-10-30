<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/academicYears.fields.name').':') !!}
    <p>{{ $academicYear->name }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/academicYears.fields.photo').':') !!}

    <p><img src="{{ $academicYear->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/academicYears.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$academicYear->is_active?'success':'danger'}}">{{__('lang.'.($academicYear->is_active?'active':'not_active'))}}</span>

    </p>
</div>



<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/academicYears.fields.created_at').':') !!}
    <p>{{ $academicYear->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/academicYears.fields.updated_at').':') !!}
    <p>{{ $academicYear->updated_at }}</p>
</div>

