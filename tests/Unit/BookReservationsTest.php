<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reservation;
use DB;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_book_can_be_checked_out()
    {
        $book = \App\Models\Book::factory()->create();
        $user = \App\Models\User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_returned()
    {
        $book = \App\Models\Book::factory()->create();
        $user = \App\Models\User::factory()->create();
        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

     /** @test */
     public function a_user_can_check_out_a_book_twice()
     {
        
        
         $book = \App\Models\Book::factory()->create();
         $user = \App\Models\User::factory()->create();
         $book->checkout($user);
         $book->checkin($user);
 
         $book->checkout($user);
         $latest_checkout = Reservation::whereNull('checked_in_at')->first();
 
         $this->assertCount(2, Reservation::all());
         $this->assertEquals($user->id, $latest_checkout->user_id);
         $this->assertEquals($book->id, $latest_checkout->book_id);
         $this->assertNull($latest_checkout->checked_in_at);
         $this->assertEquals(now(), $latest_checkout->checked_out_at);
 
         $book->checkin($user);
         $latest_checkin = Reservation::where('id',$latest_checkout->id)->first();
        
         $this->assertCount(2, Reservation::all());
         $this->assertEquals($user->id, $latest_checkin->user_id);
         $this->assertEquals($book->id, $latest_checkin->book_id);
         $this->assertNotNull($latest_checkin->checked_in_at);
         $this->assertEquals(now(), $latest_checkin->checked_in_at);
     }
}
