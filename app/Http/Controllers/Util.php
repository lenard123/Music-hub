<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Util extends Controller
{
	/**
	 * Upload File and return its path
	 * @param	{Request}	$request
	 * @param 	{String[]}	$config
	 * @return 	{String}	$path
	 */
	public static function getPath(Request $request, $config)
	{
		$file = $config['file'];
		$default = $config['default'];
		$directory = $config['directory'];
		$filename = $config['filename'];

		if (empty($request->$file))
			$path =  $default;
		else 
			$path = Storage::putFileAs($directory, $request->file($file), $filename);
			//$path = $request->file($file)->storeAs($directory, $filename);
		return $path;
	}

	/**
	 * Delete File
	 * @param 	{String}	$path
	 */
	public static function deleteFile($path)
	{
		Storage::delete($path);
	}

	/**
	 * Add default value if the request is empty
	 * @param 	{Request}	$request
	 * @param 	{String}	$name
	 * @param 	{String}	$default
	 */
    public static function getDefault($request, $name, $default = '') 
    {
    	$name1 = $request->$name;
    	$name1 = empty($name1) || empty(trim($name1));
    	if ($name1)
    		return $default;
    	else 
    		return $request->$name;
    }	
}
