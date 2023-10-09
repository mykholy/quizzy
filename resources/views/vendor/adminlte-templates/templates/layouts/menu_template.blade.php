<li class="slide @{{ Request::is('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}*') ? 'active' : '' }}">
    <a class="side-menu__item @{{ Request::is('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}*') ? 'active' : '' }}"
       href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}"
    >
        <i class=" ion-md-settings side-menu__icon"></i>
        @if($config->options->localized)
            <span class="side-menu__label">{{__('models/{{ $config->modelNames->camelPlural }}.plural')}}</span>
        @else
            <span class="side-menu__label">{{__('models/{{ $config->modelNames->camelPlural }}.plural')}}</span>
        @endif

    </a>
</li>
