<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddPlaylistResquest;
use App\Playlist;


use Illuminate\Http\Request;

class PlaylistController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['addVideo']]);
	}

	public function addVideo(AddPlaylistResquest $request){
		Playlist::create($request->all());
		return response()->json(['message' => 'added video successfully']);
	}
}
