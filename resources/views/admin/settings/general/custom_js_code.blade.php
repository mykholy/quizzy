
<!-- custom_javascript_codes Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('custom_javascript_codes'.request('lang_id',1), __('models/settings.general.JS').': ').'( </span>'.trans('models/settings.general.JS Codes Description').' </span>) ' !!}
    {!! Form::textarea('custom_javascript_codes'.request('lang_id',1), setting('custom_javascript_codes'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('custom_javascript_codes'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('custom_javascript_codes'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('custom_javascript_codes'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>


