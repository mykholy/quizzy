<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/questions.fields.name').':') !!}
    <p>{{ $question->name }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', __('models/questions.fields.type').':') !!}
    <p>{{ $question->type }}</p>
</div>

<!-- level Field -->
<div class="col-sm-12">
    {!! Form::label('level', __('models/questions.fields.level').':') !!}
    <p>{{ $question->level }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/questions.fields.description').':') !!}
    <p>{{ $question->description }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/questions.fields.photo').':') !!}
    <p><img src="{{ $question->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- File Field -->
<div class="col-sm-12">
    {!! Form::label('file', __('models/questions.fields.file').':') !!}
    <p>{{ $question->file }}</p>
</div>



<!-- Points Field -->
<div class="col-sm-12">
    {!! Form::label('points', __('models/questions.fields.points').':') !!}
    <p>{{ $question->points }}</p>
</div>

<!-- Time Field -->
<div class="col-sm-12">
    {!! Form::label('time', __('models/questions.fields.time').':') !!}
    <p>{{ $question->time }}</p>
</div>



<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/questions.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$question->is_active?'success':'danger'}}">{{__('lang.'.($question->is_active?'active':'not_active'))}}</span>

    </p>
</div>



<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/questions.fields.created_at').':') !!}
    <p>{{ $question->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/questions.fields.updated_at').':') !!}
    <p>{{ $question->updated_at }}</p>
</div>

