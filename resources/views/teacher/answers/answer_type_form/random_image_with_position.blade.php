<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('EBook/answers.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>

<div class="form-group col-sm-6 col-lg-6 mb-3" >
    {!! Form::label('answer_two_gap_match', __('EBook/answers.positions')) !!}
    {!! Form::text('answer_two_gap_match', null, ['readonly'=>'readonly','id'=>'answer_two_gap_match','class' => 'form-control' . ($errors->has('answer_two_gap_match')?' is-invalid':'')  ]) !!}
    @if ($errors->has('answer_two_gap_match'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_two_gap_match') }}</small>
         </span>
    @endif
</div>


<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('answer_view_format', __('EBook/answers.answer_view_format')) !!}

    {!! Form::select('answer_view_format',App\Models\EBook\Answer::getAllAnswerViewFormat(),null, array('class' => 'form-control select2 select2-hidden-accessible','required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}
    @if ($errors->has('answer_view_format'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_view_format') }}</small>

         </span>
    @endif


</div>



<!-- image Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    <h2 class="">{{ trans('EBook/answers.fields.answer_img') }}</h2>
    <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                           class="btn btn-primary text-white lfm">
                            <i class="fa fa-image"></i> {{ trans('lang.choose') }}
                        </a>
                    </span>
        {!! Form::text('answer_img', null, [
            'hidden' => 'hidden',
            'id' => 'thumbnail',
            'class' => 'form-control' . ($errors->has('answer_img') ? ' is-invalid' : ''),
        ]) !!}
    </div>
    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
</div>

{{--<div class="form-group col-sm-6 col-lg-6 mb-3" id="div_top">--}}
{{--    {!! Form::label('top', __('top')) !!}--}}
{{--    {!! Form::text('top', null, ['disabled'=>'disabled','id'=>'top','class' => 'form-control' . ($errors->has('top')?' is-invalid':'')  ]) !!}--}}
{{--    @if ($errors->has('top'))--}}
{{--        <span class="invalid-feedback">--}}
{{--              <small class="text-danger">{{ $errors->first('top') }}</small>--}}
{{--         </span>--}}
{{--    @endif--}}
{{--</div>--}}
{{--<div class="form-group col-sm-6 col-lg-6 mb-3" id="div_left">--}}
{{--    {!! Form::label('left', __('left')) !!}--}}
{{--    {!! Form::text('left', null, ['disabled'=>'disabled','id'=>'left','class' => 'form-control' . ($errors->has('left')?' is-invalid':'')  ]) !!}--}}
{{--    @if ($errors->has('left'))--}}
{{--        <span class="invalid-feedback">--}}
{{--              <small class="text-danger">{{ $errors->first('left') }}</small>--}}
{{--         </span>--}}
{{--    @endif--}}
{{--</div>--}}

<div class="form-group col-12 mb-3">
    <div class="area" id="area">
        <img src="{{$question->question_img}}" alt="quiz_image" onclick="getPosition(event)">
    </div>
</div>



@push('css')
    <style>
        .area {
            width: 500px;
            height: 400px;
            border: 2px dashed #ccc;
        }

        .area img {
            object-fit: contain;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
    </style>
@endpush
@push('vendor-scripts')
    <script>
        function getPosition(event) {
            const area = document.getElementById("area");
            const rect = area.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            $('#answer_two_gap_match').val(x +"," +y);
            // $('#top').val(y);
            // $('#left').val(x);
            console.log(`Clicked position: left=${x}, top=${y}`);
        }

    </script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>


    <script>
        var route_prefix = "/admin/laravel-filemanager";
        $('#lfm').filemanager('image', {
            prefix: route_prefix
        });
    </script>
@endpush
