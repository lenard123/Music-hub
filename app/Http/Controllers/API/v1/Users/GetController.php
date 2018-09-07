<?php

namespace App\Http\Controllers\API\v1\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class GetController extends Controller
{
    public function __invoke ()
    {
    	return User::all();
    }
}
