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

<h2>{{trans('models/groups.fields.students')}}</h2>

@if($group->students)
    <table class="table table-bordered table-condensed table-striped">
            <tr>
                <th>{{ __('models/students.fields.name') }}</th>
                <th>{{ __('models/students.fields.username') }}</th>
                <th>{{  __('models/students.fields.email') }}</th>
                <th>{{  __('models/students.fields.phone') }}</th>
            </tr>
        @foreach($group->students as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->username}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->phone}}</td>
            </tr>
        @endforeach

    </table>
@endif

