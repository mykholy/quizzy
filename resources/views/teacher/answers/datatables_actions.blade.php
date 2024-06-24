<div class='btn-group'>
    <a type="button" href="{{ route('teacher.answers.show', [$answer->id,'question_id'=>$answer->question_id]) }}" class="btn btn-info mx-2 button-icon mb-1 btn-sm"><i
            class="fe fe-eye me-2"></i> {{__('lang.show')}}</a>
    <a type="button" href="{{ route('teacher.answers.edit', [$answer->id,'question_id'=>$answer->question_id]) }}"
       class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i class="fe fe-edit me-2"></i> {{__('lang.edit')}}</a>
    <a id="{{$answer->id}}" style="cursor: pointer"
       class="btn btn-danger mx-2 button-icon mb-1 btn-sm remove_record">
        <i class="las la-trash"></i> {{__('lang.delete')}}

    </a>
    <form id="Row{{$answer->id}}"
          action="{{ route('teacher.answers.destroy', [$answer->id,'question_id'=>$answer->question_id]) }}"
          method="post" style="display: none">
        {{ csrf_field() }}
        {{ method_field('delete') }}

    </form>
</div>




