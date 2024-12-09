<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pilgrims extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'identification',
        'phone',
        'email',
        'address',
        'nationalty',
        'file',
        'password',
    ];
    protected $dates = ['deleted_at'];
}