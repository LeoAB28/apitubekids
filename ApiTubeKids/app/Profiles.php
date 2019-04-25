<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $fillable = [
      'name', 
      'user_name', 
      'id_father', 
      'email',  
      'key', 
      'age',
  ];
}