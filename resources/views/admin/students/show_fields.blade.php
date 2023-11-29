<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/students.fields.name').':') !!}
    <p>{{ $student->name }}</p>
</div>

<!-- username Field -->
<div class="col-sm-12">
    {!! Form::label('username', __('models/students.fields.username').':') !!}
    <p>{{ $student->username }}</p>
</div>
<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', __('models/students.fields.email').':') !!}
    <p>{{ $student->email }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', __('models/students.fields.phone').':') !!}
    <p>{{ $student->phone }}</p>
</div>

<!-- date_of_birth Field -->
<div class="col-sm-12">
    {!! Form::label('date_of_birth', __('models/students.fields.date_of_birth').':') !!}
    <p>{{ $student->date_of_birth }}</p>
</div>

<!-- governorate Field -->
<div class="col-sm-12">
    {!! Form::label('governorate', __('models/students.fields.governorate').':') !!}
    <p>{{ $student->governorate }}</p>
</div>

<!-- area Field -->
<div class="col-sm-12">
    {!! Form::label('area', __('models/students.fields.area').':') !!}
    <p>{{ $student->area }}</p>
</div>

<!-- residence_area Field -->
<div class="col-sm-12">
    {!! Form::label('residence_area', __('models/students.fields.residence_area').':') !!}
    <p>{{ $student->residence_area }}</p>
</div>

<!-- specialization Field -->
<div class="col-sm-12">
    {!! Form::label('specialization', __('models/students.fields.specialization').':') !!}
    <p>{{ $student->specialization }}</p>
</div>

<!-- academic_year_id Field -->
<div class="col-sm-12">
    {!! Form::label('academic_year_id', __('models/students.fields.academic_year_id').':') !!}
    <p>{{ optional($student->academicYear)->name }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/students.fields.photo').':') !!}

    <p><img src="{{ $student->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/students.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$student->is_active?'success':'danger'}}">{{__('lang.'.($student->is_active?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/students.fields.created_at').':') !!}
    <p>{{ $student->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/students.fields.updated_at').':') !!}
    <p>{{ $student->updated_at }}</p>
</div>

