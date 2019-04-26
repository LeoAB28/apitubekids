<?php

namespace App\Http\Controllers;


use Illumitate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class ConfirmEmailController extends Controller
{
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