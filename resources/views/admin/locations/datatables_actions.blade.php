{!! Form::open(['route' => ['admin.locations.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a title="{{trans('models/stations.add')}}" href="{{ route('admin.stations.create', ['location_id'=>$id]) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-plug"></i>
    </a>
    <a href="{{ route('admin.locations.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('admin.locations.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    <a title="update json" href="{{ route('admin.locations.edit', [$id,'update_json'=>true]) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-upload"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"

    ]) !!}
</div>
{!! Form::close() !!}
