<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Book;

class BookController extends Controller
{
    public function store(Request $request){

        $data = $this->isValidData($request);
        $book = Book::create($data);

        return redirect($book->path());
    }

    public function update(Request $request,Book $book){

        $data = $this->isValidData($request);
        $book->update($data);
        return redirect($book->path());
    }

    public function destroy(Book $book){

        $book->delete();
        return redirect('/books');
    }

    public function isValidData($request){
        return $request->validate([
            'title' =>'required',
            'author'=>'required'
        ]);
    }
}
