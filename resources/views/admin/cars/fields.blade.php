<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', __('models/cars.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'minlength' => 3, 'maxlength' => 100]) !!}
</div>
<!-- Tags Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('tags', __('models/cars.fields.tags').':') !!}
    {!! Form::text('tags', null, ['id'=>'tags','class' => 'form-control'. ($errors->has('tags')?' is-invalid ':'') ]) !!}

    @if ($errors->has('tags'))
        <span class="invalid-feedback">
                          <small class="text-danger">{{ $errors->first('tags') }}</small>
                    </span>
    @endif
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', __('models/cars.fields.photo').':') !!}
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
        {!! Form::label('is_active', __('models/cars.fields.is_active').':', ['class' => 'custom-control-label']) !!}
    </div>
</div>

@push('page_css')
    <!-- Start inputTags -->
    <link rel="stylesheet" href="{{asset('inputTags/inputTags.css')}}"/>
    <!-- End inputTags -->
@endpush
@push('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Start inputTags -->
    <script src="{{asset('inputTags/inputTags.jquery.js')}}"></script>
    <!-- End inputTags -->

    <script>
        $('#tags').inputTags({
            max: 500,
            init: function ($elem) {
                //console.log('Event called on plugin init', $elem);
                $('.inputTags-field').attr('onkeydown', 'return event.key!==\'Enter\';')
            },
            create: function () {
                // console.log('Event called when an item is created');
            },
            update: function () {
                //  console.log('Event called when an item is updated');
            },
            destroy: function () {
                // console.log('Event called when an item is deleted');
            },
            selected: function () {
                //console.log('Event called when an item is selected');
            },
            unselected: function () {
                // console.log('Event called when an item is unselected');
            },
            change: function ($elem) {

                //  console.log('Event called on item change', $elem);
            },
            autocompleteTagSelect: function ($elem) {
                // console.log('Event called on tag selection', $elem);
            }
        });


    </script>
@endpush
