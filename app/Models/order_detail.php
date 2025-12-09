<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    public function order(){
        return $this->hasMany(Order::class);
    }
    public function product(){
        return $this->hasMany(Order::class);
    }
}
