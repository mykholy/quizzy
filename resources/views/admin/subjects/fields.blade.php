<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/subjects.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>

<!-- academic_year_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('academic_year_id', __('models/subjects.fields.academic_year_id').':') !!}
    {!! Form::select('academic_year_id',\App\Models\Admin\AcademicYear::pluck('name','id')->toArray(),request('academic_year_id'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('academic_year_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('academic_year_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('academic_year_id') }}</small>

             </span>
    @endif
</div>

<!-- Semester Field -->
<div class="form-group col-sm-6">
    {!! Form::label('semester', __('models/subjects.fields.semester').':') !!}
    {!! Form::select('semester', ['-1'=>'All','1' => 'First', '2' => 'Second','3'=>'Third','4'=>'Fourth'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/subjects.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/subjects.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>

