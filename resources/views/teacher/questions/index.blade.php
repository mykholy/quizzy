@extends('layouts.app_teacher')
@section('breadcrumb')
    <?php
    $lesson=\App\Models\Admin\Lesson::find(request('lesson_id'));
    ?>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/questions.singular')}}</h4>
            <ol class="breadcrumb">
               @if($lesson) <li class="breadcrumb-item"><a href="{{route('teacher.lessons.index',['unit_id'=>$lesson?$lesson->unit_id:'#'])}}">{{$lesson->name}}</a></li>@endif
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/questions.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __('lang.list') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/questions.plural')}}</h3>

                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('teacher.questions.create',['lesson_id'=>request('lesson_id')]) }}">
                        {!! __('lang.add_new') !!}
                    </a>

                    <a class="btn btn-primary float-right"
                       href="{{ route('teacher.questions.create',['lesson_id'=>request('lesson_id'),'bulkImport'=>1]) }}">
                        {!! __('lang.bulk') !!}
                    </a>

                </div>
            </div>
            <div class="card-body">
                @include('teacher.questions.table')
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush
