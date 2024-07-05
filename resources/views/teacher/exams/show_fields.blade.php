<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/exams.fields.name').':') !!}
    <p>{{ $exam->name }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', __('models/exams.fields.type').':') !!}
    <p>{{ $exam->type }}</p>
</div>

<!-- Question Types Field -->
<div class="col-sm-12">
    {!! Form::label('question_types', __('models/exams.fields.question_types').':') !!}
    <p>{{ $exam->question_types }}</p>
</div>

<!-- Level Field -->
<div class="col-sm-12">
    {!! Form::label('level', __('models/exams.fields.level').':') !!}
    <p>{{ $exam->level }}</p>
</div>

<!-- Type Assessment Field -->
<div class="col-sm-12">
    {!! Form::label('type_assessment', __('models/exams.fields.type_assessment').':') !!}
    <p>{{ $exam->type_assessment }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/exams.fields.description').':') !!}
    <p>{{ $exam->description }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/exams.fields.photo').':') !!}
    <p><img src="{{ $exam->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>


<!-- Semester Field -->
<div class="col-sm-12">
    {!! Form::label('semester', __('models/exams.fields.semester').':') !!}
    <p>{{ $exam->semester }}</p>
</div>

<!-- Points Field -->
<div class="col-sm-12">
    {!! Form::label('points', __('models/exams.fields.points').':') !!}
    <p>{{ $exam->points }}</p>
</div>

<!-- Time Field -->
<div class="col-sm-12">
    {!! Form::label('time', __('models/exams.fields.time').':') !!}
    <p>{{ $exam->time }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/exams.fields.is_active').':') !!}
    <p>
        <span
            class=" me-1 badge bg-{{$exam->is_active?'success':'danger'}}">{{__('lang.'.($exam->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/exams.fields.created_at').':') !!}
    <p>{{ $exam->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/exams.fields.updated_at').':') !!}
    <p>{{ $exam->updated_at }}</p>
</div>

<h2>{{trans('models/groups.fields.students')}}</h2>

@if($exam->students)
    <table class="table table-bordered table-condensed table-striped">
        <tr>
            <th>{{ __('models/students.fields.name') }}</th>
            <th>{{ __('models/students.fields.username') }}</th>
            <th>{{  __('models/students.fields.email') }}</th>
            <th>{{  __('models/students.fields.phone') }}</th>
        </tr>

        @foreach($exam->students as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->username}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->phone}}</td>
            </tr>
        @endforeach

    </table>
@endif
