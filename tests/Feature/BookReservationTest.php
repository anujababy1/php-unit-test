<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookReservationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     */
    // public function test_a_book_can_be_adeed_to_library(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

      /**
     * A basic test example.
     */
    /** @test */
    public function a_book_can_be_adeed_to_library(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title'=>'A book',
            'author' => 'Abc'
        ]);

        $response->assertOk();
        $this->assertCount(1,Book::all());
    }

    public function test_a_title_is_required(){

        $response = $this->post('books',[
            'title' =>'',
            'author' =>'this a author',
        ]);
        $response->assertSessionHasErrors('title');
    }

       /** @test */

       public function a_author_is_required(){

            $response = $this->post('/books',[
                'title' =>'abc',
                'author'=>''
            ]);
            $response->assertSessionHasErrors('author');
       }

       /** @test */
       public function a_book_can_be_updated(){

            $this->withoutExceptionHandling();

            $this->post('/books',[
                'title' => 'a title',
                'author'=> 'a author'
            ]);
            $book = Book::first();

            $response = $this->patch('/books/'.$book->id,[
                'title'     => 'Updated title',
                'author'    => 'Updated author'
            ]);

            $book = Book::first();

            $this->assertEquals('Updated title',$book->title);
            $this->assertEquals('Updated author',$book->author);
       }
}
