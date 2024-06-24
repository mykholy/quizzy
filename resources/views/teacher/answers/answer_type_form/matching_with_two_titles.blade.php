<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('title', __('EBook/answers.title').'*') !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title')?' is-invalid':'')  ]) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('title') }}</small>
         </span>
    @endif
</div>

<div class="form-group col-sm-6 col-lg-6 mb-3">
    {!! Form::label('answer_two_gap_match', __('EBook/answers.matched_answer_title')) !!}
    {!! Form::text('answer_two_gap_match', null, ['class' => 'form-control' . ($errors->has('answer_two_gap_match')?' is-invalid':'')  ]) !!}
    @if ($errors->has('answer_two_gap_match'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('answer_two_gap_match') }}</small>
         </span>
    @endif
</div>

<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('match_type', __('EBook/answers.fields.match_type')) !!}

    {!! Form::select('match_type',App\Models\EBook\Answer::getAllMatchType(),null, array('class' => 'form-control select2 select2-hidden-accessible','required'=>'required', 'ui-jp'=>"select2",'ui-options'=>"{theme: 'bootstrap'}" )) !!}
    @if ($errors->has('match_type'))
        <span class="invalid-feedback">
              <small class="text-danger">{{ $errors->first('match_type') }}</small>

         </span>
    @endif


</div>

<div class="form-group col-sm-6 col-lg-6 mb-3">

    {!! Form::label('answer_two_gap_match', __('EBook/answers.answer_view_format')) !!}

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
@push('vendor-scripts')

    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>


    <script>
        var route_prefix = "/admin/laravel-filemanager";
        $('#lfm').filemanager('image', {
            prefix: route_prefix
        });
    </script>
@endpush
