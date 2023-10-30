<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', __('models/answers.fields.title').':') !!}
    <p>{{ $answer->title }}</p>
</div>

<!-- Question Type Field -->
<div class="col-sm-12">
    {!! Form::label('question_type', __('models/answers.fields.question_type').':') !!}
    <p>{{ $answer->question_type }}</p>
</div>

<!-- Answer Two Gap Match Field -->
<div class="col-sm-12">
    {!! Form::label('answer_two_gap_match', __('models/answers.fields.answer_two_gap_match').':') !!}
    <p>{{ $answer->answer_two_gap_match }}</p>
</div>

<!-- Answer View Format Field -->
<div class="col-sm-12">
    {!! Form::label('answer_view_format', __('models/answers.fields.answer_view_format').':') !!}
    <p>{{ $answer->answer_view_format }}</p>
</div>

<!-- Answer Order Field -->
<div class="col-sm-12">
    {!! Form::label('answer_order', __('models/answers.fields.answer_order').':') !!}
    <p>{{ $answer->answer_order }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/answers.fields.photo').':') !!}
    <p>{{ $answer->photo }}</p>
</div>

<!-- Is Correct Field -->
<div class="col-sm-12">
    {!! Form::label('is_correct', __('models/answers.fields.is_correct').':') !!}
    <p>{{ $answer->is_correct }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/answers.fields.created_at').':') !!}
    <p>{{ $answer->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/answers.fields.updated_at').':') !!}
    <p>{{ $answer->updated_at }}</p>
</div>

