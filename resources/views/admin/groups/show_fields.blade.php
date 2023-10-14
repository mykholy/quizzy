<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/groups.fields.name').':') !!}
    <p>{{ $group->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/groups.fields.description').':') !!}
    <p>{{ $group->description }}</p>
</div>


<!-- teacher Field -->
<div class="col-sm-12">
    {!! Form::label('teacher_id', __('models/groups.fields.teacher_id').':') !!}
    <p>{{ optional($group->teacher)->name }}</p>
</div>

<!-- subject Field -->
<div class="col-sm-12">
    {!! Form::label('subject_id', __('models/groups.fields.subject_id').':') !!}
    <p>{{ optional($group->subject)->name }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/groups.fields.photo').':') !!}

    <p><img src="{{ $group->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>



<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/groups.fields.created_at').':') !!}
    <p>{{ $group->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/groups.fields.updated_at').':') !!}
    <p>{{ $group->updated_at }}</p>
</div>

