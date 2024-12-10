<?php

namespace App\Models;

use App\Enum\Status;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Team extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    protected $guarded = ['id'];

    public $table = "teams";

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_teams', 'user_team_id', 'user_id');
    }

    public function team_lead()
    {
        return $this->belongsTo(User::class, 'team_lead_id');
    }

    public function scopeSearch($query, $search): Builder
    {
        if (isset($search['name'])) {
            $query->where('name', 'like', $search['name'].'%');
        }

        return $query;
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}

