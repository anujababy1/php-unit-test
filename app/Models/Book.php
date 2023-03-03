<?php

namespace App\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Author;

class Book extends Model
{
    //use HasFactory;

    protected $guarded = [];

    public function path(){
        return 'books/'.$this->id;
    }

    public function setAuthorIdAttribute ($author){

        $author = Author::firstOrCreate([
            'title' => $author,
        ]);
        $this->attributes['author_id'] = $author->id;
    }
}
