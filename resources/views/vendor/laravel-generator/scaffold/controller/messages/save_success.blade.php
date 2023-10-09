@if($config->options->localized)
    session()->flash('success',__('messages.saved', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')]));
@else
    session()->flash('success','{{ $config->modelNames->human }} saved successfully.');
@endif
