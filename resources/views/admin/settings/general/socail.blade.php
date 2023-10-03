<!-- facebook_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('facebook_url_'.request('lang_id',1), __('models/settings.general.Facebook URL').':') !!}
    {!! Form::url('facebook_url_'.request('lang_id',1), setting('facebook_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('facebook_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('facebook_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('facebook_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- twitter_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('twitter_url_'.request('lang_id',1), __('models/settings.general.Twitter URL').':') !!}
    {!! Form::url('twitter_url_'.request('lang_id',1), setting('twitter_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('twitter_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('twitter_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small class="text-danger">{{ $errors->first('twitter_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- instagram_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('instagram_url_'.request('lang_id',1), __('models/settings.general.Instagram URL').':') !!}
    {!! Form::url('instagram_url_'.request('lang_id',1), setting('instagram_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('instagram_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('instagram_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('instagram_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- pinterest_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('pinterest_url_'.request('lang_id',1), __('models/settings.general.Pinterest URL').':') !!}
    {!! Form::url('pinterest_url_'.request('lang_id',1), setting('pinterest_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('pinterest_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('pinterest_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('pinterest_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- linkedin_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('linkedin_url_'.request('lang_id',1), __('models/settings.general.LinkedIn URL').':') !!}
    {!! Form::url('linkedin_url_'.request('lang_id',1), setting('linkedin_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('linkedin_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('linkedin_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('linkedin_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- vk_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('vk_url_'.request('lang_id',1), __('models/settings.general.VK URL').':') !!}
    {!! Form::url('vk_url_'.request('lang_id',1), setting('vk_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('vk_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('vk_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('vk_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- telegram_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('telegram_url_'.request('lang_id',1), __('models/settings.general.Telegram URL').':') !!}
    {!! Form::url('telegram_url_'.request('lang_id',1), setting('telegram_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('telegram_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('telegram_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('telegram_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

<!-- youtube_url Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('youtube_url_'.request('lang_id',1), __('models/settings.general.Youtube URL').':') !!}
    {!! Form::url('youtube_url_'.request('lang_id',1), setting('youtube_url_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('youtube_url_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('youtube_url_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('youtube_url_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>

