<div class='btn-group'>
    <a type="button" href="{{ route('admin.lessons.index',['unit_id'=>$id]) }}"
       class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i
            class="si si-book-open   me-2"></i> {{__('models/lessons.plural')}}</a>

    <a type="button" href="{{ route('admin.units.show', [$id,'subject_id'=>request('subject_id')]) }}" class="btn btn-info mx-2 button-icon mb-1 btn-sm"><i
            class="fe fe-eye me-2"></i> {{__('lang.show')}}</a>
    <a type="button" href="{{ route('admin.units.edit', [$id,'subject_id'=>request('subject_id')]) }}"
       class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i class="fe fe-edit me-2"></i> {{__('lang.edit')}}</a>
    <a id="{{$id}}" style="cursor: pointer"
       class="btn btn-danger mx-2 button-icon mb-1 btn-sm remove_record">
        <i class="las la-trash"></i> {{__('lang.delete')}}

    </a>
    <form id="Row{{$id}}"
          action="{{ route('admin.units.destroy', [$id,'subject_id'=>request('subject_id')]) }}"
          method="post" style="display: none">
        {{ csrf_field() }}
        {{ method_field('delete') }}

    </form>
</div>




