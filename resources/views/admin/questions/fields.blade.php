<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/questions.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', __('models/questions.fields.type').':') !!}
    {!! Form::select('type',\App\Models\Admin\Question::getAllTypes(),request('type'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('type')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('type'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('type') }}</small>

             </span>
    @endif
</div>

<!-- levels Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level', __('models/questions.fields.level').':') !!}
    {!! Form::select('level',\App\Models\Admin\Question::getAllLevel(),request('level'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('level')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('level'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('level') }}</small>

             </span>
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/questions.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
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


<!-- points Field -->
<div class="form-group col-sm-6">
    {!! Form::label('points', __('models/questions.fields.points').':') !!}
    {!! Form::number('points', null, ['min'=>0,'class' => 'form-control']) !!}
</div>

<!-- time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', __('models/questions.fields.time').' (seconds) :') !!}
    {!! Form::number('time', null, ['min'=>0,'class' => 'form-control']) !!}
</div>


<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/questions.fields.photo').':') !!}
    <div class="mb-3">
        {!! Form::file('photo', ['class' => 'form-control']) !!}
    </div>
</div>


<!-- file Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file', __('models/questions.fields.file').':') !!}
    <div class="mb-3">
        {!! Form::file('file', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>


<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">

    <div class="form-checkbox custom-control">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, null,  ['id'=>'is_active','class' => 'custom-control-input']) !!}
        {!! Form::label('is_active', __('models/questions.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>



@push('page_scripts')
    <script>
        @if(!isset($question))
        change_subject($('#subject_id').val());
        change_unit($('#unit_id').val());
        @endif
        function change_subject(subject_id) {
            let url_ajax = "{{url('admin/questions')}}/" + subject_id + "/units";
            $.ajax({
                url: url_ajax,
                success: function (response) {
                    jQuery('#unit_id').html(response);
                    $('#unit_id').val(null).trigger('change');
                }
            });
        }

        function change_unit(unit_id) {
            let url_ajax = "{{url('admin/questions')}}/"+unit_id+"/lessons";
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
