<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/groups.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/groups.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>


<!-- Teacher id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('teacher_id', __('models/groups.fields.teacher_id').':') !!}
    {!! Form::select('teacher_id',\App\Models\Admin\Teacher::pluck('name','id')->toArray(),request('teacher_id'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('teacher_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('teacher_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('teacher_id') }}</small>

             </span>
    @endif
</div>

<!-- Subject id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject_id', __('models/groups.fields.subject_id').':') !!}
    {!! Form::select('subject_id',\App\Models\Admin\Subject::getSelectData(),request('subject_id'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('subject_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('subject_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('subject_id') }}</small>

             </span>
    @endif
</div>

<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('student_ids', __('models/groups.fields.student_ids').':') !!}
    {!! Form::select('student_ids[]', \App\Models\Admin\Student::pluck('name','id')->toArray(), isset($group)?$group->students->pluck('id')->toArray():null, ['multiple'=>'multiple','class' => 'form-control form-select '. ($errors->has('student_ids')?' is-invalid ':'')]) !!}

    @if ($errors->has('student_ids'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('student_ids') }}</small>

             </span>
    @endif
</div>



<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/groups.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>

