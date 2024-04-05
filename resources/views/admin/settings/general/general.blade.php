<!-- application_name Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('application_name', __('models/settings.general.Application Name').':') !!}
    {!! Form::text('application_name', setting('application_name'), ['class' => 'form-control  '. ($errors->has('application_name')?' is-invalid ':'')]) !!}

    @if ($errors->has('application_name'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('application_name') }}</small>

        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('description', __('models/settings.general.description').':') !!}
    {!! Form::text('description', setting('description'), ['class' => 'form-control  '. ($errors->has('description')?' is-invalid ':'')]) !!}

    @if ($errors->has('description'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('description') }}</small>

        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('phone', __('models/settings.general.phone').':') !!}
    {!! Form::text('phone', setting('phone'), ['class' => 'form-control  '. ($errors->has('phone')?' is-invalid ':'')]) !!}

    @if ($errors->has('phone'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('phone') }}</small>

        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('version', __('models/settings.general.version').':') !!}
    {!! Form::text('version', setting('version'), ['class' => 'form-control  '. ($errors->has('version')?' is-invalid ':'')]) !!}
    @if ($errors->has('version'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('version') }}</small>
        </span>
    @endif
</div>

<div class="form-group col-sm-12 col-lg-6 mb-3">
    {!! Form::label('terms', __('models/settings.general.terms').':') !!}
    {!! Form::textarea('terms', setting('terms'), ['class' => 'form-control  '. ($errors->has('terms')?' is-invalid ':'')]) !!}

    @if ($errors->has('terms'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('terms') }}</small>

        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-6 mb-3">
    {!! Form::label('privacy_policy', __('models/settings.general.privacy_policy').':') !!}
    {!! Form::textarea('privacy_policy', setting('privacy_policy'), ['class' => 'form-control  '. ($errors->has('privacy_policy')?' is-invalid ':'')]) !!}

    @if ($errors->has('privacy_policy'))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('privacy_policy') }}</small>

        </span>
    @endif
</div>

<!-- logo Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('logo', __('models/settings.general.logo').':') !!}
    {!! Form::file('logo',['accept'=>'.jpg, .png, image/jpeg, image/png','data-default-file'=>(asset(setting('logo'))), 'data-height'=>'150','class' => 'form-control dropify '. ($errors->has('logo')?' is-invalid':'')]) !!}

    @if ($errors->has('logo'))
        <span class="invalid-feedback">

                     <small class="text-danger">{{ $errors->first('logo') }}</small>

                 </span>
    @endif
</div>
<div class="clearfix"></div>

<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('balance_default','balance_default:') !!}
    {!! Form::number('balance_default', setting('balance_default'), ['min'=>0,'class' => 'form-control  '. ($errors->has('balance_default')?' is-invalid ':'')]) !!}
    @if ($errors->has('balance_default'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('balance_default') }}</small>
        </span>
    @endif
</div>

<div class="form-group col-sm-12 col-lg-6 mb-3">
    {!! Form::label('inviter_gift','Inviter Gift:') !!}
    {!! Form::number('inviter_gift', setting('inviter_gift'), ['min'=>0,'class' => 'form-control  '. ($errors->has('inviter_gift')?' is-invalid ':'')]) !!}
    @if ($errors->has('inviter_gift'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('inviter_gift') }}</small>
        </span>
    @endif
</div>


<div class="form-group col-sm-12 col-lg-6 mb-3">
    {!! Form::label('invitee_gift','Invitee Gift:') !!}
    {!! Form::number('invitee_gift', setting('invitee_gift'), ['min'=>0,'class' => 'form-control  '. ($errors->has('invitee_gift')?' is-invalid ':'')]) !!}
    @if ($errors->has('invitee_gift'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('invitee_gift') }}</small>
        </span>
    @endif
</div>

<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('text_similarity_long_answer','Text Similarity Long answer:') !!}
    {!! Form::number('text_similarity_long_answer', setting('text_similarity_long_answer'), ['min'=>0,'max'=>100,'class' => 'form-control  '. ($errors->has('text_similarity_long_answer')?' is-invalid ':'')]) !!}
    @if ($errors->has('text_similarity_long_answer'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('text_similarity_long_answer') }}</small>
        </span>
    @endif
</div>
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('text_similarity_short_answer','Text Similarity Short answer:') !!}
    {!! Form::number('text_similarity_short_answer', setting('text_similarity_short_answer'), ['min'=>0,'max'=>100,'class' => 'form-control  '. ($errors->has('text_similarity_short_answer')?' is-invalid ':'')]) !!}
    @if ($errors->has('text_similarity_short_answer'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('text_similarity_short_answer') }}</small>
        </span>
    @endif
</div>

{{--<div class="form-group col-sm-12 col-lg-12 mb-3">--}}
{{--    {!! Form::label('base_url_api','Base URl API:') !!}--}}
{{--    {!! Form::text('base_url_api', setting('base_url_api'), ['class' => 'form-control  '. ($errors->has('base_url_api')?' is-invalid ':'')]) !!}--}}
{{--    @if ($errors->has('base_url_api'))--}}
{{--        <span class="invalid-feedback">--}}
{{--            <small class="text-danger">{{ $errors->first('base_url_api') }}</small>--}}
{{--        </span>--}}
{{--    @endif--}}
{{--</div>--}}
{{--{!! Form::text('block_app', setting('block_app',0), ['class' => 'form-control  '. ($errors->has('block_app')?' is-invalid ':'')]) !!}--}}
{{--{!! Form::text('show_balance', setting('show_balance',1), ['class' => 'form-control  '. ($errors->has('show_balance')?' is-invalid ':'')]) !!}--}}


<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('fcm_key','fcm_key:') !!}
    {!! Form::text('fcm_key', setting('fcm_key'), ['class' => 'form-control  '. ($errors->has('fcm_key')?' is-invalid ':'')]) !!}
    @if ($errors->has('fcm_key'))
        <span class="invalid-feedback">
            <small class="text-danger">{{ $errors->first('fcm_key') }}</small>
        </span>
    @endif
</div>


<input name="type_page_setting" value="general" hidden>
<!-- Submit Field -->
<div class="btn-showcase mt-5">
    {!! Form::submit(ucfirst(__('lang.save')), ['class' => 'btn btn-primary']) !!}
    <input class="btn btn-light" type="reset" value="{{ucfirst(__('lang.reset'))}}">
</div>
