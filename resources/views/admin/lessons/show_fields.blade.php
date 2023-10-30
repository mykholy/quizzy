<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/lessons.fields.name').':') !!}
    <p>{{ $lesson->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/lessons.fields.description').':') !!}
    <p>{{ $lesson->description }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/lessons.fields.photo').':') !!}

    <p><img src="{{ $lesson->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/lessons.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$lesson->is_active?'success':'danger'}}">{{__('lang.'.($lesson->is_active?'active':'not_active'))}}</span>

    </p>
</div>




<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/lessons.fields.created_at').':') !!}
    <p>{{ $lesson->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/lessons.fields.updated_at').':') !!}
    <p>{{ $lesson->updated_at }}</p>
</div>

