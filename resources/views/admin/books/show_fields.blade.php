<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/books.fields.name').':') !!}
    <p>{{ $book->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/books.fields.description').':') !!}
    <p>{{ $book->description }}</p>
</div>

<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', __('models/books.fields.photo').':') !!}

    <p><img src="{{ $book->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/books.fields.is_active').':') !!}

    <p>
        <span
            class=" me-1 badge bg-{{$book->is_active?'success':'danger'}}">{{__('lang.'.($book->is_active?'active':'not_active'))}}</span>

    </p>
</div>



<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/books.fields.created_at').':') !!}
    <p>{{ $book->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/books.fields.updated_at').':') !!}
    <p>{{ $book->updated_at }}</p>
</div>

