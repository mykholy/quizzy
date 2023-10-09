<div class='btn-group'>
    <a type="button" href="{{ route('admin.teachers.show', $id) }}" class="btn btn-info mx-2 button-icon mb-1 btn-sm"><i
            class="fe fe-eye me-2"></i> {{__('lang.show')}}</a>
    <a type="button" href="{{ route('admin.teachers.edit', $id) }}"
       class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i class="fe fe-edit me-2"></i> {{__('lang.edit')}}</a>
    <a id="{{$id}}" style="cursor: pointer"
       class="btn btn-danger mx-2 button-icon mb-1 btn-sm remove_record">
        <i class="las la-trash"></i> {{__('lang.delete')}}

    </a>
    <form id="Row{{$id}}"
          action="{{ route('admin.teachers.destroy', $id) }}"
          method="post" style="display: none">
        {{ csrf_field() }}
        {{ method_field('delete') }}

    </form>
    <!-- end of form -->
    {{--    <a href="{{ route('admin.teachers.show', $id) }}" class='btn btn-default btn-xs'>--}}
    {{--        <i class="fa fa-eye"></i>--}}
    {{--    </a>--}}
    {{--    <a href="{{ route('admin.teachers.edit', $id) }}" class='btn btn-default btn-xs'>--}}
    {{--        <i class="fa fa-edit"></i>--}}
    {{--    </a>--}}
    {{--    {!! Form::button('<i class="fa fa-trash"></i>', [--}}
    {{--        'type' => 'submit',--}}
    {{--        'class' => 'btn btn-danger btn-xs',--}}
    {{--        'onclick' => "return confirm('Are you sure?')"--}}

    {{--    ]) !!}--}}
</div>
