<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
    
    public function restrictions()
    {
        return $this->hasMany(Restrictions::class);
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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