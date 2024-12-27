<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaigns extends Model
{
    protected $fillable = ['name', 'date', 'user_id', 'status'];

    use HasFactory;

    public function pluses(): HasMany
    {
        return $this->hasMany(Plus::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stages::class);
    }
}
