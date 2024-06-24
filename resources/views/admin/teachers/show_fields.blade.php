<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/teachers.fields.name').':') !!}
    <p>{{ $teacher->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', __('models/teachers.fields.email').':') !!}
    <p>{{ $teacher->email }}</p>
</div>

<!-- phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', __('models/teachers.fields.phone').':') !!}
    <p>{{ $teacher->phone }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/teachers.fields.photo').':') !!}

    <p><img src="{{ $teacher->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/teachers.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$teacher->is_active?'success':'danger'}}">{{__('lang.'.($teacher->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/teachers.fields.created_at').':') !!}
    <p>{{ $teacher->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/teachers.fields.updated_at').':') !!}
    <p>{{ $teacher->updated_at }}</p>
</div>

