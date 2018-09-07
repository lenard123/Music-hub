<?php

namespace App\Http\Controllers\API\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;

class UpdateController extends Controller
{

	private $directory;
	private $default;

	public function __construct ()
	{
		$this->directory = config('app.image.user.0');
		$this->default = config('app.image.user.1');
	}

    public function __invoke (Request $request)
    {
    	$this->validateRequest($request);
    	$this->updateUser($request);
    	return $request->user();
    }

    private function updateUser ($request)
    {
    	$user = $request->all();
    	$user['image'] = $this->getImage($request);
    	if ($this->hasPassword($request))
    		$user['password'] = bcrypt($request->password);
    	$request->user()->update($user);
    }

    private function getImage ($request)
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->directory;
    	$config['default'] = $this->default;
    	$config['filename'] = time().'.jpg';

    	$path = Util::getPath($request, $config);
    	$old_image = $request->user()->image;
    	if ($path != $this->default && $old_image != $this->default)
    		Util::deleteFile($old_image);

    	return $path;
    }

    private function validateRequest ($request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
    		'c_email' => 'same:email',
    		'image' => ['nullable', 'image']
    	]);

    	if ($this->hasPassword($request))
    		$this->validate($request, [
    			'password' => 'required',
    			'c_password' => 'same:password'
    		]);
    }

    private function hasPassword ($request)
    {
    	return !empty($request->password);
    }
}
