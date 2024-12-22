<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restrictions extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function tree4()
    {
        return $this->belongsTo(Tree4::class, 'tree4_code', 'id');
    }
}
