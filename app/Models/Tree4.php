<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree4 extends Model
{
    use HasFactory;

    public function tree3()
    {
        return $this->belongsTo(Tree3::class, 'tree3_code', 'tree3_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}