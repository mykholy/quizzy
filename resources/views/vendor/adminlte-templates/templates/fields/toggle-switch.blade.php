<!-- 'bootstrap / Toggle Switch {{ $fieldTitle }} Field' -->
<div class="form-group col-sm-6">
    <div class="custom-control custom-switch">
        @{!! Form::hidden('{{ $fieldName }}', 0) !!}
        @{!! Form::checkbox('{{ $fieldName }}', 1, null,  ['id'=>'{{ $fieldName }}','class' => 'custom-control-input']) !!}
@if($config->options->localized)
        @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':', ['class' => 'custom-control-label']) !!}
@else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:', ['class' => 'custom-control-label']) !!}
@endif
    </div>
</div>
