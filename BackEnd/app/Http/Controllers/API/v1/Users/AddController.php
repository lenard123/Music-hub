<?php

namespace App\Http\Controllers\API\v1\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\User;

class AddController extends Controller
{

	private $directory;
	private $default;

	public function __construct()
	{
		$this->directory = config('app.image.user.0'); 
		$this->default = config('app.image.user.1');
	}

    public function __invoke (Request $request)
    {
    	$this->validateRequest($request);
    	return $this->insertUser($request);
    }

    private function insertUser ($request)
    {
    	$user = $request->all();
    	$user['image'] = $this->getImage($request);
    	$user['password'] = bcrypt($user['password']);
    	return User::create($user);
    }

    private function getImage($request)
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->directory;
    	$config['default'] = $this->default;
    	$config['filename'] = time().'.jpg';
    	return Util::getPath($request, $config);
    }

    private function validateRequest ($request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => ['required', 'email', 'unique:users'],
    		'c_email' => 'same:email',
    		'password' => 'required',
    		'c_password' => 'same:password',
    		'image' => ['nullable', 'image']
    	]);
    }
}
