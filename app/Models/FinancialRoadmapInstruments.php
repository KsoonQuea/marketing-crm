<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRoadmapInstruments extends Model
{
    public $table = 'financial_roadmap_instruments';

    protected $fillable = [
        'proposed_limit', 'interest_rate', 'tenor', 'commitments', 'new_commitments', 'financial_roadmap_id', 'group_id'
    ];

    public function financial_roadmap()
    {
        return $this->belongsTo(FinancialRoadmap::class, 'financial_roadmap_id');
    }
}
