<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/questions.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', __('models/questions.fields.type').':') !!}
    {!! Form::select('type', \App\Models\Admin\Question::getAllTypes(), request('type'), ['class' => 'form-control form-select '. ($errors->has('type')?' is-invalid ':'')]) !!}

    @if ($errors->has('type'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('type') }}</small>

             </span>
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/questions.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- lesson id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lesson_id', __('models/questions.fields.lesson_id').':') !!}
    {!! Form::select('lesson_id', \App\Models\Admin\Lesson::pluck('name','id')->toArray(), request('lesson_id'), ['class' => 'form-control form-select '. ($errors->has('lesson_id')?' is-invalid ':'')]) !!}

    @if ($errors->has('subject_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('lesson_id') }}</small>

             </span>
    @endif
</div>

<!-- academic_year_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('academic_year_id', __('models/questions.fields.academic_year_id').':') !!}
    {!! Form::select('academic_year_id', \App\Models\Admin\AcademicYear::pluck('name','id')->toArray(), request('academic_year_id'), ['class' => 'form-control form-select '. ($errors->has('academic_year_id')?' is-invalid ':'')]) !!}

    @if ($errors->has('academic_year_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('academic_year_id') }}</small>

             </span>
    @endif
</div>

<!-- Semester Field -->
<div class="form-group col-sm-6">
    {!! Form::label('semester', __('models/questions.fields.semester').':') !!}
    {!! Form::select('semester', ['1' => 'First', '2' => 'Second'], null, ['class' => 'form-control custom-select']) !!}
</div>



<!-- points Field -->
<div class="form-group col-sm-6">
    {!! Form::label('points', __('models/questions.fields.points').':') !!}
    {!! Form::number('points', null, ['min'=>0,'class' => 'form-control']) !!}
</div>

<!-- time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', __('models/questions.fields.time').' (seconds) :') !!}
    {!! Form::number('time', null, ['min'=>0,'class' => 'form-control']) !!}
</div>


<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/questions.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>


<!-- file Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file', __('models/questions.fields.file').':') !!}
    <div class="mb-3">
        {!! Form::file('file', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>






<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/questions.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>



