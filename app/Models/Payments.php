<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Payments extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Done',
    ];

    public $table = 'payments';

    protected $fillable = ['date', 'cheque_no', 'or', 'sst_paid_date', 'case_id', 'case_disburse_detail_id', 'paid_amount','status'];

    public function getDocumentAttribute()
    {
        $files = $this->getMedia('document');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
        });
        return $files;
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class,'case_id');
    }

    public function case_disburse_detail()
    {
        return $this->belongsTo(CaseDisburseDetails::class,'case_disburse_detail_id');
    }
}
