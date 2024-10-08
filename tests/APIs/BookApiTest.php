<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Book;

class BookApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_book()
    {
        $book = Book::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/books', $book
        );

        $this->assertApiResponse($book);
    }

    /**
     * @test
     */
    public function test_read_book()
    {
        $book = Book::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/books/'.$book->id
        );

        $this->assertApiResponse($book->toArray());
    }

    /**
     * @test
     */
    public function test_update_book()
    {
        $book = Book::factory()->create();
        $editedBook = Book::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/books/'.$book->id,
            $editedBook
        );

        $this->assertApiResponse($editedBook);
    }

    /**
     * @test
     */
    public function test_delete_book()
    {
        $book = Book::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/books/'.$book->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/books/'.$book->id
        );

        $this->response->assertStatus(404);
    }
}
