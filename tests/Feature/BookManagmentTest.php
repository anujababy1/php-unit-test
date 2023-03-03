<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BookManagmentTest extends TestCase
{
    //use DatabaseTransactions;
    use RefreshDatabase;
    
    // public function test_a_book_can_be_adeed_to_library(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

     
    /** @test */
    public function a_book_can_be_adeed_to_library(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',$this->data());

        //$response->assertOk();
        $this->assertCount(1,Book::all());

        $book = Book::first();
        $response->assertRedirect($book->path());
    }

    public function test_a_title_is_required(){

        $response = $this->post('books',array_merge($this->data(),['title'=>'']));
        $response->assertSessionHasErrors('title');
    }

       /** @test */

       public function a_author_is_required(){

            $response = $this->post('/books',array_merge($this->data(),['author_id'=>'']));
            $response->assertSessionHasErrors('author_id');
       }

       /** @test */
       public function a_book_can_be_updated(){

            $this->withoutExceptionHandling();

            $this->post('/books',$this->data());
            $book = Book::first();

            $response = $this->patch('/books/'.$book->id,[
                'title'     => 'Updated title',
                'author_id'    => 'Updated author'
            ]);

            $book = Book::first(); //dd($book);
            $author = Author::where('title','Updated author')->first();

            $this->assertEquals('Updated title',$book->title);
            $this->assertEquals($author->id,$book->author_id);

            $response->assertRedirect($book->path());
       }

       /** @test */
       public function a_book_can_be_deleted(){

            $response = $this->post('/books',$this->data());
            $this->assertCount(1,Book::all());

            $book = Book::first();
            $response = $this->delete('/books/'.$book->id);
            $this->assertCount(0,Book::all());
            $response->assertRedirect('/books');
       }

        /** @test */
        public function a_new_author_is_automatically_added()
        {
            $this->withoutExceptionHandling();

            $this->post('/books', [
                'title' => 'Cool Title',
                'author_id' => 'Victor',
            ]);

            $book = Book::first();
            $author = Author::first();
            

            $this->assertEquals($author->id, $book->author_id);
            $this->assertCount(1, Author::all());
        }
       
       private function data()
        {
            return [
                'title' => 'Cool Book Title',
                'author_id' => 'Victor',
            ];
        }
}
