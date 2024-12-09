<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree3 extends Model
{
    use HasFactory;

    
    public function tree2()
    {
        return $this->belongsTo(Tree2::class, 'tree2_code', 'tree2_code');
    }
}
