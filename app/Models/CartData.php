<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartData extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function user (){
        return $this->belongsTo(User::class);
    }
}
