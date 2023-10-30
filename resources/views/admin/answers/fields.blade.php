<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('models/answers.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Question Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('question_type', __('models/answers.fields.question_type').':') !!}
    {!! Form::text('question_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Answer Two Gap Match Field -->
<div class="form-group col-sm-6">
    {!! Form::label('answer_two_gap_match', __('models/answers.fields.answer_two_gap_match').':') !!}
    {!! Form::text('answer_two_gap_match', null, ['class' => 'form-control']) !!}
</div>

<!-- Answer View Format Field -->
<div class="form-group col-sm-6">
    {!! Form::label('answer_view_format', __('models/answers.fields.answer_view_format').':') !!}
    {!! Form::select('answer_view_format', ['text' => 'Text', 'image' => 'Image', 'text_image' => 'Text with image'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Answer Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('answer_order', __('models/answers.fields.answer_order').':') !!}
    {!! Form::text('answer_order', null, ['class' => 'form-control']) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/answers.fields.photo').':') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('photo', ['class' => 'custom-file-input']) !!}
            {!! Form::label('photo', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!-- 'bootstrap / Toggle Switch Is Correct Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        {!! Form::hidden('is_correct', 0) !!}
        {!! Form::checkbox('is_correct', 1, null,  ['id'=>'is_correct','class' => 'custom-control-input']) !!}
        {!! Form::label('is_correct', __('models/answers.fields.is_correct').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>
