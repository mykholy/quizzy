<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/units.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/units.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- subject_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject_id', __('models/units.fields.subject_id').':') !!}
    {!! Form::select('subject_id',\App\Models\Admin\Subject::pluck('full_name','id')->toArray(),request('subject_id'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('subject_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('subject_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('subject_id') }}</small>

             </span>
    @endif
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/units.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/units.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>


