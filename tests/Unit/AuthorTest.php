<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_title_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'title' => 'John Doe',
        ]);

        $this->assertCount(1, Author::all());
    }
}
