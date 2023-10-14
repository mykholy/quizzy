@@extends('layouts.app')
@@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            @if($config->options->localized)
                <h4 class="page-title">@{{ __('models/{!! $config->modelNames->camelPlural !!}.singular')}}</h4>
            @else
                <h4 class="page-title">{{ $config->modelNames->humanPlural }}</h4>
            @endif
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">@{{ __('models/{!! $config->modelNames->camelPlural !!}.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@{{ __('lang.edit')}}</li>
            </ol>
        </div>
    </div>
@@endsection
@@section('content')


    <div class="col-lg-12">

        @@include('adminlte-templates::common.errors')

        <div class="card">

            @{!! Form::model(${{ $config->modelNames->camel }}, ['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.update', ${{ $config->modelNames->camel }}->{{ $config->primaryName }}], 'method' => 'patch','files'=>true]) !!}
            @{!! Form::hidden('id',${{ $config->modelNames->camel }}->{{ $config->primaryName }}) !!}
            <div class="card-body">
                <div class="row">
                    @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.fields')
                </div>
            </div>

            <div class="card-footer">
                @{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}" class="btn btn-default">@if($config->options->localized) @@lang('lang.cancel') @else Cancel @endif</a>
            </div>

            @{!! Form::close() !!}

        </div>
    </div>
@@endsection
