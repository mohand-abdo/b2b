<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree2 extends Model
{
    use HasFactory;
    
    public function tree1()
    {
        return $this->belongsTo(Tree1::class, 'tree1_code', 'tree1_code');
    }
}
