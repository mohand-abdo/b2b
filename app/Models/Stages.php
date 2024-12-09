<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;
    protected $fillable = ['campaign_id', 'stage', 'user_id'];

    public function campaign()
    {
        return $this->belongsTo(Campaigns::class, 'campaign_id');
    }
}