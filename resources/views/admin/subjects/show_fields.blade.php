<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/subjects.fields.name').':') !!}
    <p>{{ $subject->name }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/subjects.fields.photo').':') !!}

    <p><img src="{{ $subject->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/subjects.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$subject->is_active?'success':'danger'}}">{{__('lang.'.($subject->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/subjects.fields.created_at').':') !!}
    <p>{{ $subject->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/subjects.fields.updated_at').':') !!}
    <p>{{ $subject->updated_at }}</p>
</div>

