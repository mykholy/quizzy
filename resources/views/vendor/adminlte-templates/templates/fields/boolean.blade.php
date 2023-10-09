<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div class="form-group col-sm-6">
    <div class="form-checkbox custom-control">
        @{!! Form::hidden('{{ $fieldName }}', 0) !!}
        @{!! Form::checkbox('{{ $fieldName }}', 1, null,  ['id'=>'{{ $fieldName }}','class' => 'custom-control-input']) !!}
        @if($config->options->localized)
            @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':', ['class' => 'custom-control-label mt-1']) !!}
        @else
            @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:', ['class' => 'custom-control-label mt-1']) !!}

        @endif
    </div>

</div>



