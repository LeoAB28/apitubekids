<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Nexmo\Laravel\Facade\Nexmo;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or password does\'t exist'], 401);
        } 
        $user = DB::table('users')->where('email', request(['email']))->first();
        if($user->verify_email){
            return $this->respondWithToken($token);
        }else{
          return response()->json(['error' => 'Your email has not been confirmed'], 401);  
      }
  }

  public function signup(SignUpRequest $request)
  {

    $date = Carbon::now();
    $date = $date->format('d-m-Y');
    $dateUser = $request->birthdate;
    $dateUser = Carbon::parse($dateUser)->format('d-m-Y');
    $years = Carbon::parse($dateUser)->age;

    if($years<18){
       return response()->json(['error'=>'You have to be older than 18 years', 'code'=>409], 409);
   }else{
    User::create($request->all());
    User::generarMail($request->email);
    $random = rand(1000,9999);
    $this->sendSMS('506', $request->phone, $random);
}
}

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->name,
            'id' => auth()->user()->id
        ]);
    }

    public function sendSMS($country_code, $phone, $authy_id){
        Nexmo::message()->send([
            'to' =>$country_code.$phone,
            'from' => ' TubeKids es',
            'text' => 'Codigo de verificiacion de la cuenta TubeKids'.$authy_id.' confirmalo   '
        ]);
    }
}