<?php

namespace App\Http\Controllers\API\v1\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Category;

class DeleteController extends Controller
{

	private $directory;
	private $default;

	public function __construct()
	{
		$this->directory = config('app.image.category.0'); 
		$this->default = config('app.image.category.1');
	}

    public function __invoke ($id)
    {
    	$category = Category::find($id);

        if ($category->songs->count() > 0) {
            return response("Category contains songs", 591);
        }

    	$this->deleteImage($category->image);
    	$category->delete();
    	return Category::all();
    }

    private function deleteImage ($file)
    {
    	if ($file!==$this->default)
    		Util::deleteFile($file);
    }
}
