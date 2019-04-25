<?php

namespace App\Http\Controllers;


use Illumitate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class ConfirmEmailController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count()> 0 ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')->where(['email' => $request->email,'token' =>$request->resetToken]);
    }

    private function tokenNotFoundResponse()
    {
        return response()->json(['error' => 'Token or Email is incorrect'],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update(['password'=>$request->password]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data'=>'Password Successfully Changed'],Response::HTTP_CREATED);
    }

    public function confirmEmail($email){

       $user = DB::table('users')->where('email',$email)->first();
       if($user){

        if($user->verify_email){
            echo('<h1>Su correo ya a sido confirmado anteriormente!!</h1>');  
        }else{
            DB::table('users')->where(['email' => $user->email])->update(['verify_email' => true]);
            echo('<h1>Gracias por confirmar su correo!!</h1>'); 
        }
    }   
  }
}