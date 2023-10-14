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
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/{!! $config->modelNames->camelPlural !!}.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> @@lang('lang.detail')</li>
            </ol>
        </div>
    </div>
@@endsection
@@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/{!! $config->modelNames->camelPlural !!}.plural')}} {{ __('lang.detail')}}</h3>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">
                        {{ __('lang.back')}}
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.show_fields')
                </div>
            </div>
        </div>
    </div>
@@endsection
