<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BookDataTable;
use App\Http\Requests\Admin\CreateBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Book;
use Illuminate\Http\Request;


class BookController extends AppBaseController
{
    /**
     * Display a listing of the Book.
     */
    public function index(BookDataTable $bookDataTable)
    {
    return $bookDataTable->render('admin.books.index',['subject_id' => request('subject_id')]);
    }


    /**
     * Show the form for creating a new Book.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created Book in storage.
     */
    public function store(CreateBookRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('books', $request->photo);

        }

        /** @var Book $book */
        $book = Book::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/books.singular')]));

        return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
    }

    /**
     * Display the specified Book.
     */
    public function show($id)
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            session()->flash('error',__('models/books.singular').' '.__('messages.not_found'));


            return redirect(route('admin.books.index'));
        }

        return view('admin.books.show',['subject_id'=>request('subject_id')])->with('book', $book);
    }

    /**
     * Show the form for editing the specified Book.
     */
    public function edit($id)
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            session()->flash('error',__('models/books.singular').' '.__('messages.not_found'));


            return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
        }

        return view('admin.books.edit',['subject_id'=>request('subject_id')])->with('book', $book);
    }

    /**
     * Update the specified Book in storage.
     */
    public function update($id, UpdateBookRequest $request)
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            session()->flash('error',__('models/books.singular').' '.__('messages.not_found'));


            return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('books', $request->photo);
        }

        $book->fill($request_data);
        $book->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/books.singular')]));

        return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
    }

    /**
     * Remove the specified Book from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            session()->flash('error',__('models/books.singular').' '.__('messages.not_found'));


            return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
        }

        $book->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/books.singular')]));


        return redirect(route('admin.books.index',['subject_id'=>request('subject_id')]));
    }
}
