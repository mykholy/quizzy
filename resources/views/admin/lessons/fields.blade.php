<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/lessons.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/lessons.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- unit_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_id', __('models/lessons.fields.unit_id').':') !!}
    {!! Form::select('unit_id', \App\Models\Admin\Unit::pluck('name','id')->toArray(), request('unit_id'), ['class' => 'form-control form-select '. ($errors->has('unit_id')?' is-invalid ':'')]) !!}

    @if ($errors->has('unit_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('unit_id') }}</small>

             </span>
    @endif
</div>
<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/lessons.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/lessons.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>

