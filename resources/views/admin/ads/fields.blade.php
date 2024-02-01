<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('models/ads.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/academicYears.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/academicYears.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>

