@extends('layouts.app_teacher')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/questions.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('teacher.questions.index',['lesson_id'=>request('lesson_id')]) }}">{{ __('models/questions.singular')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{__('lang.create')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <div class="col-lg-8">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'teacher.questions.bulkImport','files'=>true]) !!}
            <input type="hidden" name="lesson_id" value="{{request('lesson_id')}}">
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-12">
                        <div class="alert alert-primary"
                             style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                            <svg class="flex-shrink-0 me-2 svg-primary" xmlns="http://www.w3.org/2000/svg"
                                 height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path
                                    d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path>
                            </svg>
                            <strong>Step 1:</strong>
                            <p>1. Download the skeleton file and fill it with proper data.</p>
                            <p>2. You can download the example file to understand how the data must be filled.</p>
                            <p>3. Once you have downloaded and filled the skeleton file, upload it in the form below and
                                submit.</p>
                            <p> type
                                : {{implode(' | ',collect(\App\Models\Admin\Question::getAllTypes())->keys()->toArray())}} </p>
                            <p> level
                                : {{implode(' | ',collect(\App\Models\Admin\Question::getAllLevel())->keys()->toArray())}} </p>
                            <p> answer_view_format
                                : {{implode(' | ',collect(\App\Models\Admin\Answer::getAllAnswerViewFormat())->keys()->toArray())}} </p>
                        </div>
                        <br>
                        <div class="my-2">
                            <a class="btn btn-info" href="{{ asset('download/question_bulk_demo.xlsx') }}" download>Download
                                CSV</a>
                            <a class="btn btn-info mx-2" href="{{ asset('download/question_bulk_demo_short_long.xlsx') }}" download>Download For Short And Long Questions
                                CSV</a>
                        </div>
                    </div>
                    <!-- file Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('bulk_file', __('models/questions.fields.file').':') !!}
                        <div class="mb-3">
                            {!! Form::file('bulk_file', ['class' => 'form-control','accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel']) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('teacher.questions.index',['lesson_id'=>request('lesson_id')]) }}"
                   class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
    <div class="col-lg-4">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header">
                <h4>Upload Center Files</h4>
            </div>

            {!! Form::open(['route' => 'teacher.questions.bulkImport','files'=>true]) !!}
            <input type="hidden" name="lesson_id" value="{{request('lesson_id')}}">
            <div class="card-body">

                <div class="row">
                    @if(isset($files_url_data))
                        <div class="form-group col-12 mb-3">
                        <textarea class="form-control" name="my_textarea"
                                  rows="15">{{ implode("\n\n", $files_url_data) }}</textarea>
                        </div>
                    @endif

                    <!-- file Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('files', __('models/questions.fields.files').':') !!}
                        <div class="mb-3">
                            {!! Form::file('upload_files[]', ['class' => 'form-control','multiple'=>'multiple']) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('teacher.questions.index',['lesson_id'=>request('lesson_id')]) }}"
                   class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
