<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseDetail extends Model
{
    protected $fillable = [
        'case_number',
        'case_type',
        'case_diary_id',
    ];
    public function caseType()
    {
        return $this->belongsTo(CaseType::class, 'case_type', 'id');
    }
    public function caseTypeBadge($caseDiaryId)
    {
        $cases = CaseType::query()->where('case_diary_id', $caseDiaryId)->get();
        $caseArr = [];
        foreach ($cases as $case) {
            $caseArr[] = $case->case_number . "(".")";
        }
        return $caseArr;
    }
}
