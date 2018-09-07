<?php

namespace App\Http\Controllers\API\v1\Song;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Song;

class AddController extends Controller
{

	private $img_directory;
	private $song_directory;
	private $default;

	public function __construct () 
    {
		$this->img_directory = config('app.image.song.0');
		$this->default = config('app.image.song.1');
		$this->song_directory = config('app.song_directory');
	}

    public function __invoke (Request $request) 
    {
    	$this->validateRequest($request); //Validate Request first
    	return $this->insertSong($request);
    }

    private function insertSong ($request) 
    {
    	$song = $request->all();
    	$song['image'] = $this->getImagePath($request);
    	$song['music'] = $this->getMusicPath($request);
    	$song['singer'] = Util::getDefault($request, 'singer', 'Unknown');
    	$song['composer'] = Util::getDefault($request, 'composer', 'Unknown');
    	$song['lyrics'] = Util::getDefault($request, 'lyrics', '');
    	return Song::create($song);
    }

    private function getMusicPath ($request) 
    {
    	$config['file'] = 'music';
    	$config['directory'] = $this->song_directory;
    	$config['default'] = 'song/failed.mp4';
    	$config['filename'] = time().'.mp3';
    	return Util::getPath($request, $config);
    }

    private function getImagePath ($request) 
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->img_directory;
    	$config['default'] = $this->default;
    	$config['filename'] = time().'.jpg';
    	return Util::getPath($request, $config);
    }

    private function validateRequest($request) 
    {
    	$this->validate($request, [
    		'image' => ['nullable', 'image'],
    		'category_id' => ['required', 'exists:category,id'],
    		'title' => 'required',
   			'music' => ['required', 'mimetypes:audio/mpeg'],
    	]);
    }
}
