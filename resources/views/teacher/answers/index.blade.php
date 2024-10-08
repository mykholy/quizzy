@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/answers.singular')}} ({{$question->name}} ) ( {{\App\Models\Admin\Question::getQuestionType($question->type)}})</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('teacher.questions.index',['lesson_id' => $question->lesson_id])}}">{{$question->name}}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/answers.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __('lang.list') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/answers.plural')}}</h3>

                <div class="col-sm-6">
                    @if( \App\Models\Admin\Answer::checkQuestionsTypeCanAddManyAnswers($question->type))

                    <a class="btn btn-primary float-right"
                       href="{{ route('teacher.answers.create',['question_id'=>$question->id]) }}">
                        {!! __('lang.add_new') !!}
                    </a>
                        @endif

                </div>
            </div>
            <div class="card-body">
                @include('teacher.answers.table')
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush
