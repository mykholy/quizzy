<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('models/ads.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/ads.fields.photo').':') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('photo', ['class' => 'custom-file-input']) !!}
            {!! Form::label('photo', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/ads.fields.is_active').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>
