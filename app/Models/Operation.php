<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

     //  دائن
     public function Dains()
     {
         return $this->belongsTo(Tree4::class, 'Dain', 'tree4_code');
     }
    // مدين
    public function Madins() 
    {
        return $this->belongsTo(Tree4::class, 'Madin', 'tree4_code');
    }

    // المستخدمين
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
  
}
