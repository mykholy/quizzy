
<!-- custom_css_codes Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('custom_css_codes_'.request('lang_id',1), __('models/settings.general.CSS').': ').'( </span>'.trans('models/settings.general.Css Codes Description').' </span>) ' !!}
    {!! Form::textarea('custom_css_codes_'.request('lang_id',1), setting('custom_css_codes_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('custom_css_codes_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('custom_css_codes_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('custom_css_codes_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>


