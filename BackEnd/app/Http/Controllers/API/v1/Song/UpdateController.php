<?php

namespace App\Http\Controllers\API\v1\Song;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Song;

class UpdateController extends Controller
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

    public function __invoke (Request $request, $id) 
    {
    	$this->validateRequest($request, $id);
    	$this->updateSong($request, $id);
    	return Song::find($id);
    }

    private function updateSong ($request, $id)
    {
    	$song = $request->all();
    	$song['image'] = $this->getImagePath($request, $id);
    	$song['music'] = $this->getMusicPath($request, $id);
    	$song['singer'] = Util::getDefault($request, 'singer', 'Unknown');
    	$song['composer'] = Util::getDefault($request, 'composer', 'Unknown');
    	$song['lyrics'] = Util::getDefault($request, 'lyrics', '');
    	Song::find($id)->update($song);
    }

    private function getMusicPath ($request, $id)
    {
    	$old_file = Song::find($id)->music;

    	//If the request contains music
    	if (!empty($request->music)) {
	    	$config['file'] = 'music';
	    	$config['directory'] = $this->song_directory;
	    	$config['default'] = 'song/failed.mp4';
	    	$config['filename'] = time().'.mp3';

			$path = Util::getPath($request, $config);//Upload it
			Util::deleteFile($old_file); //Then delete the old music
		} else {
			$path = $old_file; //Else return the old music
		}

		return $path;
    }

    private function getImagePath ($request, $id)
    {
    	$config['file'] = 'image';
    	$config['directory'] = $this->img_directory;
    	$config['filename'] = time().'.jpg';
    	$config['default'] = $this->default;

    	$path = Util::getPath($request, $config);

    	//IF the uploaded file is not default image
    	if ($path != $this->default)
    		//And the old image is not default
    		if (Song::find($id)->image != $this->default)
    			//Then delete it
    			Util::deleteFile(Song::find($id)->image);

    	return $path;
    }

    private function validateRequest ($request, $id) 
    {
    	$this->validate($request, [
    		'image' => ['nullable', 'image'],
    		'category_id' => ['required', 'exists:category,id'],
    		'title' => 'required',
    		'music' => ['nullable', 'mimetypes:audio/mpeg']
    	]);
    }
}
