<?php

namespace App\Http\Controllers\API\v1\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Song;

class GetController extends Controller
{
    public function __invoke ()
    {
    	return Category::all();
    }

    public function show ($id)
    {
    	return Category::find($id);
    }

    public function song ($id)
    {
    	return Song::where('category_id', $id)->paginate(10);
    }
}
