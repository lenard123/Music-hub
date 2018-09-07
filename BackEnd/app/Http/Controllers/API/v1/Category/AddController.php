<?php

namespace App\Http\Controllers\API\v1\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Category;

class AddController extends Controller
{

	private $directory;
	private $default;

	public function __construct()
	{
		$this->directory = config('app.image.category.0'); 
		$this->default = config('app.image.category.1');
	}

    public function __invoke (Request $request)
    {
    	$this->validateRequest($request);
    	return $this->insertCategory($request);
    }

    private function validateRequest ($request)
    {
    	$this->validate($request, [
    		'name' => ['required', 'unique:category'],
    		'image' => ['nullable', 'image']
    	]);
    }

    private function insertCategory ($request)
    {
    	$category = $request->all();
    	$category['image'] = $this->getPath($request);

    	return Category::create($category);
    }

    private function getPath($request)
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->directory;
    	$config['default'] = $this->default;
    	$config['filename'] = time().'.jpg';
    	return Util::getPath($request, $config);
    }

}
