@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        @lang('lang.edit') @lang('models/locations.singular')
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($location, ['route' => ['admin.locations.update', $location->id], 'method' => 'patch','files'=>true]) !!}

            <div class="card-body">
                <div class="row">
                    @if((\request('update_json')))
                        <div class="form-group col-sm-6">
                            {!! Form::label('json_location', __('models/locations.fields.json').':') !!}
                            {!! Form::textarea('json_location', null, ['class' => 'form-control']) !!}
                        </div>
                    @else
                        @include('admin.locations.fields')
                    @endif
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
