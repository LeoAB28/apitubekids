<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProfileRequest;
use App\Profiles;

class ProfilesController extends Controller
{
        /**
     * Create a new ProfilesController instance.
     *
     * @return void
     */
        public function __construct()
        {
        	$this->middleware('auth:api', ['except' => ['getProfilesByIdFather', 'addProfile', 'destroy', 'putProfile']]);
        }

        public function getProfilesByIdFather($id){
        	$profiles = [];
        	$profiles = DB::table('profiles')->where('id_father',$id)->get();
        	if($profiles){
        		return response()->json(['profiles' => $profiles]);
        	}else{
        		return response()->json(['error' => 'It does not have profiles'], 401);
        	}
        }

        public function addProfile(AddProfileRequest $request){
          Profiles::create($request->all());
          return response()->json(['message' => 'added successfully']);
        }


        public function destroy($id){
          $profile = DB::table('profiles')->where('id', $id)->first();
          if($profile){
            DB::table('profiles')->where('id', $id)->delete();
            return response()->json(['data' => 'The Profile delete successfully'], 204);
          }else{
            return response()->json(['error' => 'The Profile does not exists'], 401);
          }
        }

        public function putProfile(AddProfileRequest $request){
          $profile = Profiles::whereId($request->id)->first();
          $profile->name = $request->name;
          $profile->user_name = $request->user_name;
          $profile->key = $request->key;
          $profile->age = $request->age;

          if($profile->save()){
            return response()->json(['data' => 'The Profile delete successfully'], 204);
          } else{
           return response()->json(['error' => 'The Profile does not exists'], 401);
         }
       }
     }

