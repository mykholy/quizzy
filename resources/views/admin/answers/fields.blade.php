<div class="row">
    @include('admin.answers.answer_type_form.'.$question->type)
    <input hidden name="question_id" value="{{request('question_id')}}">

    {{--<!-- Title Field -->--}}
    {{--<div class="form-group col-sm-6">--}}
    {{--    {!! Form::label('title', __('models/answers.fields.title').':') !!}--}}
    {{--    {!! Form::text('title', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}



    {{--<!-- Answer Two Gap Match Field -->--}}
    {{--<div class="form-group col-sm-6">--}}
    {{--    {!! Form::label('answer_two_gap_match', __('models/answers.fields.answer_two_gap_match').':') !!}--}}
    {{--    {!! Form::text('answer_two_gap_match', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}

    {{--<!-- Answer View Format Field -->--}}
    {{--<div class="form-group col-sm-6">--}}
    {{--    {!! Form::label('answer_view_format', __('models/answers.fields.answer_view_format').':') !!}--}}
    {{--    {!! Form::select('answer_view_format', ['text' => 'Text', 'image' => 'Image', 'text_image' => 'Text with image'], null, ['class' => 'form-control custom-select']) !!}--}}
    {{--</div>--}}


    <div class="form-group col-sm-6 col-lg-6 mb-3">
        {!! Form::label('answer_order', __('models/answers.fields.answer_order').'*') !!}
        {!! Form::number('answer_order', null, ['min'=>1,'class' => 'form-control' . ($errors->has('answer_order')?' is-invalid':'')  ]) !!}
        @if ($errors->has('answer_order'))
            <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_order') }}</small>
         </span>
        @endif
    </div>


    <!-- Photo Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('photo', __('models/answers.fields.photo').':') !!}
        <div class="mb-3">
            {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        @if ($errors->has('photo'))
            <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('photo') }}</small>
         </span>
        @endif
    </div>


    {{--<!-- 'bootstrap / Toggle Switch Is Correct Field' -->--}}
    {{--<div class="form-group col-sm-6">--}}
    {{--    <div class="custom-control custom-switch">--}}
    {{--        {!! Form::hidden('is_correct', 0) !!}--}}
    {{--        {!! Form::checkbox('is_correct', 1, null,  ['id'=>'is_correct','class' => 'custom-control-input']) !!}--}}
    {{--        {!! Form::label('is_correct', __('models/answers.fields.is_correct').':', ['class' => 'custom-control-label']) !!}--}}
    {{--    </div>--}}
    {{--</div>--}}
</div>
