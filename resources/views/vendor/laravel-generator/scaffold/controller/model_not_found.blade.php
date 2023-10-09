        if (empty(${{ $config->modelNames->camel }})) {
@if($config->options->localized)
            session()->flash('error',__('models/{{ $config->modelNames->camelPlural }}.singular').' '.__('messages.not_found')));

@else
            session()->flash('error','{{ $config->modelNames->human }} not found.');

@endif

            return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
        }
