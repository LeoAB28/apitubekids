<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
	protected $fillable = [
		'name',
		'url', 
		'id_father', 
	];
}
