<div class='btn-group'>
    @if( App\Models\Admin\Question::checkQuestionsTypeHaveAnswers($question->question_type))
        <a type="button" href="{{ route('admin.answers.index',['question_id'=>$question->id]) }}"
           class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i
                class="fa fa-question-circle me-2"></i> {{ trans('models/answers.plural') }}
        </a>
    @endif
    <a type="button" href="{{ route('admin.questions.show', [$question->id,'lesson_id'=>$question->lesson_id]) }}" class="btn btn-info mx-2 button-icon mb-1 btn-sm"><i
            class="fe fe-eye me-2"></i> {{__('lang.show')}}</a>
    <a type="button" href="{{ route('admin.questions.edit', [$question->id,'lesson_id'=>$question->lesson_id]) }}"
       class="btn btn-primary mx-2 button-icon mb-1 btn-sm"><i class="fe fe-edit me-2"></i> {{__('lang.edit')}}</a>
    <a id="{{$question->id}}" style="cursor: pointer"
       class="btn btn-danger mx-2 button-icon mb-1 btn-sm remove_record">
        <i class="las la-trash"></i> {{__('lang.delete')}}

    </a>
    <form id="Row{{$question->id}}"
          action="{{ route('admin.questions.destroy', [$question->id,'lesson_id'=>$question->lesson_id]) }}"
          method="post" style="display: none">
        {{ csrf_field() }}
        {{ method_field('delete') }}

    </form>
</div>




