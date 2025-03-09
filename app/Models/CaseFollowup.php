<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseFollowup extends Model
{
    protected $guarded = [];

    public function advocate()
    {
        //advocate_attended
        return $this->belongsTo(Advocate::class, 'advocate_attended', 'id');
    }
}
