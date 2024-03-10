@extends('layouts.app')
@section('breadcrumb')
    <?php
    $subject=\App\Models\Admin\Subject::find(request('subject_id'));
    ?>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/books.singular')}} ({{$subject?$subject->name:'----'}})</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.subjects.index')}}">{{ __('models/subjects.singular')}}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/books.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __('lang.list') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/books.plural')}}</h3>

                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.books.create',['subject_id'=>request('subject_id')]) }}">
                        {!! __('lang.add_new') !!}
                    </a>

                </div>
            </div>
            <div class="card-body">
                @include('admin.books.table')
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush
