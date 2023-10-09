@if($config->options->localized)
    session()->flash('success',__('messages.updated', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')]));
@else
    session()->flash('success','{{ $config->modelNames->human }} updated successfully.');

@endif
