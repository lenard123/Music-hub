<?php

namespace App\Http\Controllers\API\v1\Song;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Song;

class GetController extends Controller
{
    public function __invoke ()
    {
    	return Song::paginate(10);
    }

    public function show ($id)
    {
    	return Song::find($id);
    }
}
