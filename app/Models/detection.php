<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detection extends Model
{
    use HasFactory;

    public function passenger()
    {
        return $this->hasMany(Passengers::class, 'number', 'number');
    } 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cars()
    {
        return $this->belongsTo(Cars::class, 'car', 'id');
    }
    public function drivers()
    {
        return $this->belongsTo(Tree4::class, 'driver', 'tree4_code');
    }

    public function froms()
    {
        return $this->belongsTo(Travel::class, 'from', 'id');
    }

    public function tos()
    {
        return $this->belongsTo(Travel::class, 'to', 'id');
    }
}

