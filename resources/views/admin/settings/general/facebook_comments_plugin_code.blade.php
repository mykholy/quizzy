
<!-- facebook_comment Field -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    {!! Form::label('facebook_comment_'.request('lang_id',1), __('models/settings.general.Facebook Comments Plugin Code').':') !!}
    {!! Form::textarea('facebook_comment_'.request('lang_id',1), setting('facebook_comment_'.request('lang_id',1),null), ['class' => 'form-control  '. ($errors->has('facebook_comment_'.request('lang_id',1))?' is-invalid ':'')]) !!}

    @if ($errors->has('facebook_comment_'.request('lang_id',1)))
        <span class="invalid-feedback">

                <small
                    class="text-danger">{{ $errors->first('facebook_comment_'.request('lang_id',1)) }}</small>

        </span>
    @endif
</div>


