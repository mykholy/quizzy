<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/exams.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('type', __('models/exams.fields.type').':') !!}--}}
{{--    {!! Form::select('type',\App\Models\Admin\Exam::getAllTypes(),request('type'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('type')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}--}}

{{--    @if ($errors->has('type'))--}}
{{--        <span class="invalid-feedback">--}}

{{--                <small class="text-danger">{{ $errors->first('type') }}</small>--}}

{{--             </span>--}}
{{--    @endif--}}
{{--</div>--}}

<!-- Question Types Field -->
<div class="form-group col-sm-6">
    {!! Form::label('question_types', __('models/exams.fields.question_types').':') !!}
    {!! Form::select('question_types',\App\Models\Admin\Question::getAllTypes(),request('question_types'), array('multiple'=>'multiple','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('type')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('question_types'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('question_types') }}</small>

             </span>
    @endif
</div>

<!-- Level Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level', __('models/exams.fields.level').':') !!}
    {!! Form::select('level',\App\Models\Admin\Question::getAllLevel(),request('level'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('level')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('level'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('level') }}</small>

             </span>
    @endif
</div>

<!-- Type Assessment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_assessment', __('models/exams.fields.type_assessment').':') !!}
    {!! Form::select('type_assessment',\App\Models\Admin\Exam::getAllTypeAssessment(),request('type_assessment'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('level')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('type_assessment'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('type_assessment') }}</small>

             </span>
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/exams.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/exams.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>

<!-- Semester Field -->
<div class="form-group col-sm-6">
    {!! Form::label('semester', __('models/exams.fields.semester').':') !!}
    {!! Form::select('semester', ['1' => 'First', '2' => 'Second','3'=>'Third','4'=>'Fourth'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- subject_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject_id', __('models/questions.fields.subject_id').':') !!}
    {!! Form::select('subject_id',\App\Models\Admin\Subject::getSelectData(),request('subject_id'), array('id'=>'subject_id','onchange'=>'change_subject(this.value);','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('subject_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('subject_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('subject_id') }}</small>

             </span>
    @endif
</div>
<!-- book_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('book_id', __('models/questions.fields.book_id').':') !!}
    {!! Form::select('book_id',\App\Models\Admin\Book::pluck('name','id')->toArray(),request('book_id'), array('onchange'=>'change_book(this.value);','id'=>'book_id','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('book_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('book_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('book_id') }}</small>

             </span>
    @endif
</div>
<!-- unit_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_id', __('models/questions.fields.unit_id').':') !!}
    {!! Form::select('unit_id',\App\Models\Admin\Unit::pluck('name','id')->toArray(),request('unit_id'), array('onchange'=>'change_unit(this.value);','id'=>'unit_id','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('unit_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('unit_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('unit_id') }}</small>

             </span>
    @endif
</div>

<!-- lesson id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lesson_id', __('models/questions.fields.lesson_id').':') !!}
    {!! Form::select('lesson_id',\App\Models\Admin\Lesson::pluck('name','id')->toArray(),request('lesson_id'), array('id'=>'lesson_id','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('lesson_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('lesson_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('lesson_id') }}</small>

             </span>
    @endif
</div>



<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/exams.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>


@push('page_scripts')
    <script>
        @if(!isset($exam))
        change_subject($('#subject_id').val());
        change_book($('#book_id').val());
        change_unit($('#unit_id').val());
        @endif
        function change_subject(subject_id) {
            let url_ajax = "{{url('teacher/questions')}}/" + subject_id + "/books";
            $.ajax({
                url: url_ajax,
                success: function (response) {
                    jQuery('#book_id').html(response);
                    $('#book_id').val(null).trigger('change');
                }
            });
        }
        function change_book(book_id) {
            let url_ajax = "{{url('teacher/questions')}}/" + book_id + "/units";
            $.ajax({
                url: url_ajax,
                success: function (response) {
                    jQuery('#unit_id').html(response);
                    $('#unit_id').val(null).trigger('change');
                }
            });
        }

        function change_unit(unit_id) {
            let url_ajax = "{{url('teacher/questions')}}/"+unit_id+"/lessons";
            $.ajax({
                url: url_ajax ,
                success: function (response) {
                    jQuery('#lesson_id').html(response);
                    $('#lesson_id').val(null).trigger('change');
                }
            });
        }
    </script>
@endpush
