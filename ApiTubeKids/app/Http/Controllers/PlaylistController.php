<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddPlaylistResquest;
use App\Playlist;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class PlaylistController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['addVideo', 'getVideo', 'destroy']]);
	}

	public function addVideo(AddPlaylistResquest $request){
		Playlist::create($request->all());
		return response()->json(['message' => 'added video successfully']);
	}

	public function getVideo($id){
		$playlist = [];
		$playlist = DB::table('playlists')->where('id_father',$id)->get();
		if($playlist){
			return response()->json(['playlist' => $playlist]);
		}else{
			return response()->json(['error' => 'It does not have playlist'], 401);
		}
	}

	public function destroy($id){
		$playlist = DB::table('playlists')->where('id', $id)->first();
		if($playlist){
			DB::table('playlists')->where('id', $id)->delete();
			return response()->json(['data' => 'The Profile delete successfully'], 204);
		}else{
			return response()->json(['error' => 'The Profile does not exists'], 401);
		}
	}
}