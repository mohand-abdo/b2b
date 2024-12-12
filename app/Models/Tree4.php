<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tree4 extends Model
{
    use HasFactory;

    public function tree3(): BelongsTo
    {
        return $this->belongsTo(Tree3::class, 'tree3_code', 'tree3_code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pluses(): HasMany
    {
        return $this->hasMany(Plus::class);
    }

}