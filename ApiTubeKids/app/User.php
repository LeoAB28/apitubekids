<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 
      'first_last_name', 
      'second_last_name', 
      'email',  
      'password', 
      'country', 
      'birthdate', 
      'phone',
      'verify_email',
  ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public static function generarMail($pemail){

        $data =[
         'email' => $pemail,
         'url' => 'api/confirm/'.$pemail,
         'subject'=>'Link de confirmacion de correo',
         'bodyMessage'=>'Ingrese al siguiente link para confirmar su correo electronico'
     ];

     Mail::send('Email.index', $data ,function ($message) use ($data){

        $message->from('leoantonio97@hotmail.com');
        $message->to($data['email']);
        $message->subject($data['subject']);
        //Log::info('Mensaje borrado');
    });
 }
}
