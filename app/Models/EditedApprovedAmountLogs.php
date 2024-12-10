<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditedApprovedAmountLogs extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function case_disburse()
    {
        return $this->belongsTo(CaseDisburse::class, 'case_disburse_id');
    }
}
