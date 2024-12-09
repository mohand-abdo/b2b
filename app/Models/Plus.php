<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plus extends Model
{
    use HasFactory;

    protected $table = 'pluses';

    // The attributes that are mass assignable
    protected $fillable = [
        'stage_id',
        'tree4_id',
        'tree4_code',
        'campaign_id',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Define any relationships here
    public function stage()
    {
        return $this->belongsTo(Stages::class);
    }

    public function tree4()
    {
        return $this->belongsTo(Tree4::class);
    }
    public function Campaign()
    {
        return $this->belongsTo(Campaigns::class, 'campaign_id', 'id');
    }

}