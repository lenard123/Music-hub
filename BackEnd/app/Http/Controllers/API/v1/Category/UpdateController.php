<?php

namespace App\Http\Controllers\API\v1\Category;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Category;

class UpdateController extends Controller
{

	private $directory;
	private $default;

	public function __construct()
	{
		$this->directory = config('app.image.category.0'); 
		$this->default = config('app.image.category.1');
	}

    public function __invoke (Request $request, $id)
    {
        $this->validateRequest($request, $id);
    	$this->updateCategory($request, $id);
    	return Category::find($id);
    }

    private function validateRequest ($request, $id)
    {
    	$this->validate($request, [
    		'image' => ['nullable', 'image'],
            'name' => ['required', Rule::unique('category')->ignore($id)]
    	]);
    }

    private function updateCategory ($request, $id)
    {
    	$category = $request->all();

        //If the request contains image
    	if (!empty($request->image))
            //Upload it and get it's path
 	   		$category['image'] = $this->getPath($request, $id);

 	   	Category::find($id)->update($category);
    }

    private function getPath ($request, $id)
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->directory;
    	$config['filename'] = time().'.jpg';
    	$config['default'] = $this->default;
    	
        $path = Util::getPath($request, $config);

        if ($path != $config['default'])
            $this->deleteFile($id);

        return $path;
    }

    private function deleteFile ($id) {
        $file = Category::find($id)->image;
        if ($file !== $this->default)
            Util::deleteFile($file);
    }
}
