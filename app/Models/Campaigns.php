<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $fillable = ['name', 'date', 'user_id', 'status'];

    use HasFactory;
}
