<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/students.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('models/students.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'minlength' => 3, 'maxlength' => 255]) !!}
</div>

<!-- password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('models/students.fields.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control', 'minlength' => 6]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', __('models/students.fields.phone').':') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'minlength' => 6, 'maxlength' => 20]) !!}
</div>

<!-- area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area', __('models/students.fields.area').':') !!}
    {!! Form::select('area',['gaza'=>trans('models/students.gaza'),'west'=>trans('models/students.west')],request('area'), array('id'=>'area','onchange'=>'changeArea()','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('area')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('area'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('area') }}</small>

             </span>
    @endif
</div>

<!-- governorate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governorate', __('models/students.fields.governorate').':') !!}
    {!! Form::select('governorate',[],request('governorate'), array('id'=>'governorate','onchange'=>'changeGovernorate()','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('governorate')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('governorate'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('governorate') }}</small>

             </span>
    @endif
</div>

<!-- location_area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_area', __('models/students.fields.location_area').':') !!}
    {!! Form::select('location_area',[],request('location_area'), array('id'=>'location_area','class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('location_area')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('location_area'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('location_area') }}</small>

             </span>
    @endif
</div>



<!-- residence_area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('residence_area', __('models/subjects.fields.residence_area').':') !!}
    {!! Form::select('residence_area',\App\Models\Admin\Student::stateOfAreaList,request('residence_area'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('residence_area')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('residence_area'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('residence_area') }}</small>

             </span>
    @endif
</div>

<!-- specialization Field -->
<div class="form-group col-sm-6">
    {!! Form::label('specialization', __('models/students.fields.specialization').':') !!}
    {!! Form::text('specialization', null, ['class' => 'form-control']) !!}
</div>

<!-- academic_year_id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('academic_year_id', __('models/subjects.fields.academic_year_id').':') !!}
    {!! Form::select('academic_year_id',\App\Models\Admin\AcademicYear::pluck('name','id')->toArray(),request('academic_year_id'), array('class' => 'form-control select2 select2-hidden-accessible'. ($errors->has('academic_year_id')?' is-invalid ':''),'required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}

    @if ($errors->has('academic_year_id'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('academic_year_id') }}</small>

             </span>
    @endif
</div>



<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/students.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/students.fields.is_active').':', ['class' => 'custom-control-label mt-1']) !!}

    </div>

</div>
@push('')
    <script >
        function changeArea() {
            var area = document.getElementById('area').value;
            var governorateSelect = document.getElementById('governorate');

            // Clear existing options
            governorateSelect.innerHTML = '';

            var governorateList = [];

            // Select the appropriate governorate list based on the selected area
            if (area === 'gaza') {
                governorateList = {!! json_encode(\App\Models\Admin\Student::governoratListGaza) !!};
            } else if (area === 'west') {
                governorateList = {!! json_encode(\App\Models\Admin\Student::governorateListWest) !!};
            }

            // Populate governorate dropdown with the selected list
            governorateList.forEach(function(governorate) {
                var option = document.createElement('option');
                option.value = governorate;
                option.text = governorate;
                governorateSelect.appendChild(option);
            });
        }
        function changeGovernorate() {
            var governorate = document.getElementById('governorate').value;
            var locationAreaSelect = document.getElementById('location_area');

            // Clear existing options
            locationAreaSelect.innerHTML = '';

            var areaList = {!! json_encode(\App\Models\Admin\Student::getAreaName) !!};

            // Fetch areas for the selected governorate
            var areas = areaList[governorate] || [];

            // Populate location_area dropdown with the selected areas
            areas.forEach(function(area) {
                var option = document.createElement('option');
                option.value = area;
                option.text = area;
                locationAreaSelect.appendChild(option);
            });
        }
    </script>
    @endpush
