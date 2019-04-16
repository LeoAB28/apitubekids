<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';
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
      'email_verified_at', 
      'password',
      'verified',
      'verification_token', 
      'country', 
      'birthdate', 
      'phone',
      
    ];

    public function setNameAttribue($valor){
        $this->attributes['name'] = strtolower($valor);
    }
    public function getNameAttribute($valor){
        return ucfirst($valor);
    }

     public function setEmailAttribue($valor){
        $this->attributes['email'] = strtolower($valor);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function esVerificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public static function generarVerificationToken(){
        return str_random(40);
    }
}