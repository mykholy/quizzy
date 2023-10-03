@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        @lang('lang.import') @lang('models/locations.singular')
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'admin.locations.import','files'=>true]) !!}

            <div class="card-body">
                <div class="row">

                    <div class="form-group col-sm-6">
                        {!! Form::label('json_locations', __('models/locations.fields.json_locations').':') !!}
                        {!! Form::textarea('json_locations', null, ['class' => 'form-control']) !!}
                    </div>

                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.locations.index') }}" class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
