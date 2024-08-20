<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Phone;

class Users extends Model
{
    //use HasFactory;
    public $timestamps=false;
    protected $fillable=['id','name','email','password','created_at'];
    protected $keyType= 'string'; // Ensure UUIDs are treated as strings
    

Public function  phone()
  {
    return $this->hasOne(Phone::class, 'user_id');
  }
}
