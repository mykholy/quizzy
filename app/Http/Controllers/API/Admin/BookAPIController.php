<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateBookAPIRequest;
use App\Http\Requests\API\Admin\UpdateBookAPIRequest;
use App\Models\Admin\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\BookResource;

/**
 * Class BookAPIController
 */
class BookAPIController extends AppBaseController
{
    /**
     * Display a listing of the Books.
     * GET|HEAD /books
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::query();

        if ($request->get('subject_id')) {
            $query->where('subject_id',$request->get('subject_id'));
        }if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $books = $query->get();

        return $this->sendResponse(
            BookResource::collection($books),
            __('messages.retrieved', ['model' => __('models/books.plural')])
        );
    }

    /**
     * Store a newly created Book in storage.
     * POST /books
     */
    public function store(CreateBookAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Book $book */
        $book = Book::create($input);

        return $this->sendResponse(
            new BookResource($book),
            __('messages.saved', ['model' => __('models/books.singular')])
        );
    }

    /**
     * Display the specified Book.
     * GET|HEAD /books/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/books.singular')])
            );
        }

        return $this->sendResponse(
            new BookResource($book),
            __('messages.retrieved', ['model' => __('models/books.singular')])
        );
    }

    /**
     * Update the specified Book in storage.
     * PUT/PATCH /books/{id}
     */
    public function update($id, UpdateBookAPIRequest $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/books.singular')])
        );
        }

        $book->fill($request->all());
        $book->save();

        return $this->sendResponse(
            new BookResource($book),
            __('messages.updated', ['model' => __('models/books.singular')])
        );
    }

    /**
     * Remove the specified Book from storage.
     * DELETE /books/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Book $book */
        $book = Book::find($id);

        if (empty($book)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/books.singular')])
            );
        }

        $book->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/books.singular')])
        );
    }
}
