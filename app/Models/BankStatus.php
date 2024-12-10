<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Auditable;

    protected $guarded = [];

    public $table = 'bank_status';

}
