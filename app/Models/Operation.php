<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operation extends Model
{
    use HasFactory;

     //  دائن
     public function Dains(): BelongsTo
     {
         return $this->belongsTo(Tree4::class, 'Dain', 'tree4_code');
     }
    // مدين
    public function Madins(): BelongsTo 
    {
        return $this->belongsTo(Tree4::class, 'Madin', 'tree4_code');
    }

    public function plus(): BelongsTo 
    {
        return $this->belongsTo(Plus::class);
    }

    // المستخدمين
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
  
}
