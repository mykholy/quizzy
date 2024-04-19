<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/students.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('models/students.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'minlength' => 3, 'maxlength' => 255]) !!}
</div>

<!-- password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('models/students.fields.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control', 'minlength' => 6]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', __('models/students.fields.phone').':') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'minlength' => 6, 'maxlength' => 20]) !!}
</div>

<!-- governorate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governorate', __('models/students.fields.governorate').':') !!}
    {!! Form::text('governorate', null, ['class' => 'form-control']) !!}
</div>
<!-- area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area', __('models/students.fields.area').':') !!}
    {!! Form::text('area', null, ['class' => 'form-control']) !!}
</div>

<!-- residence_area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('residence_area', __('models/students.fields.residence_area').':') !!}
    {!! Form::text('residence_area', null, ['class' => 'form-control']) !!}
</div>

<!-- specialization Field -->
<div class="form-group col-sm-6">
    {!! Form::label('specialization', __('models/students.fields.specialization').':') !!}
    {!! Form::text('specialization', null, ['class' => 'form-control']) !!}
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



<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/students.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/students.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>
