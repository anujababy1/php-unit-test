<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function store(Request $request){

        $data = $this->validateRequest($request);
        $author = Author::create($data);

        //return redirect($author->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'dob' => 'required',
        ]);
    }
}
