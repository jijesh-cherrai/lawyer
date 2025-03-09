<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseDiary extends Model
{
    protected $fillable = [
        'court_id',
        'party_names',
        'mobile',
        'opposit_lawyer',
        'notes',
        'upcoming_case_date',
        'status',
    ];
    protected $casts = [
        'party_names' => 'array',
    ];
    /**
     * relationship for the court
     */
    public function court()
    {
        return $this->belongsTo(Court::class, 'court_id', 'id');
    }
    public function caseDetails()
    {
        return $this->hasMany(CaseDetail::class, 'case_diary_id');
    }
    public function caseFollowup()
    {
        return $this->hasMany(CaseFollowup::class, 'case_diary_id');
    }
}
