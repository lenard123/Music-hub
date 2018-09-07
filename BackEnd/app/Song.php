<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
    	'category_id', 
    	'title', 
    	'singer', 
    	'composer', 
    	'lyrics',
    	'image',
    	'music'
    ];
}
