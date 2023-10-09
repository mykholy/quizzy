@if($config->options->localized)
    session()->flash('success',__('messages.deleted', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')]));

@else
    session()->flash('success','{{ $config->modelNames->human }} deleted successfully.');

@endif
