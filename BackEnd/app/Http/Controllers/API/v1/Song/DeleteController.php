<?php

namespace App\Http\Controllers\API\v1\Song;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Song;

class DeleteController extends Controller
{
	private $directory;
	private $default;

	public function __construct()
	{
		$this->directory = config('app.image.song.0'); 
		$this->default = config('app.image.song.1');
	}

    public function __invoke ($id)
    {
    	$song = Song::find($id);
    	$this->deleteImage($song->image);
    	Util::deleteFile($song->music);
    	$song->delete();
    	return Song::paginate(10);
    }

    private function deleteImage($path)
    {
    	if ($path != $this->default)
    		Util::deleteFile($path);
    }
}
