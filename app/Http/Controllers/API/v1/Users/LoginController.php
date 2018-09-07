<?php

namespace App\Http\Controllers\API\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __invoke (Request $request)
    {
    	$this->validateRequest($request);

    	if ($this->chkLogin($request)) {
    		$user = Auth::user();
    		$result['token'] = $user->createToken('musichub')->accessToken;
    		return response()->json($result);
    	} else {
    		return response('Wrong User or Password!', 401);
    	}

    }

    private function validateRequest ($request)
    {
    	$this->validate($request, [
    		'email' => ['required', 'email'],
    		'password' => ['required']
    	]);
    }

    private function chkLogin ($request)
    {
    	return Auth::attempt($request->all());
    }
}
