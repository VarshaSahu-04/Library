<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class Phone extends Model
{
    protected $fillable = ['id', 'user_id', 'number']; // Add your fields here4
    protected $table = 'phone';


    public function user()
    {
        return $this->belongsTo(Users::class, 'id');
    }
}