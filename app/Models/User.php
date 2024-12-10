<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use Notifiable;
    use Auditable;
    use HasFactory;
    use HasRoles;
    use HasPermissions;
    use InteractsWithMedia;

    public const GENDER_SELECT = [
        '0' => 'Male',
        '1' => 'Female',
    ];


    public const CLASS_SELECT = [
        '0' => '1',
        '1' => '2',
        '2' => '3',
    ];

    public const STATUS_SELECT = [
        '0' => 'Inactive',
        '1' => 'Active',
    ];

    public $table = 'users';

    protected $guard_name = 'admin';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => Status::class,
    ];

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => Status::Active,
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected function avatar(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                $file = $this->getFirstMedia('avatar');
                if ($file) {
                    $file->url = $file->getUrl();
                    $file->thumbnail = $file->getUrl('thumb');
                    $file->preview = $file->getUrl('preview');
                }
                return $file;
            },
        );
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_teams', 'user_id','user_team_id');
    }


    public function scopeActive($query): Builder
    {
        return $query->whereStatus(Status::Active);
    }

    public function scopeInactive($query): Builder
    {
        return $query->whereStatus(Status::Inactive);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function class(){
        return $this->belongsTo(commissionSettings::class, 'class_id');
    }

    public function scopeSearch($query, $search): Builder
    {
        if (isset($search['name'])) {
            $query->where('name', 'like', $search['name'] . '%');
        }
        if (isset($search['email'])) {
            $query->where('email', 'like', $search['email'] . '%');
        }
        if (isset($search['status'])) {
            $query->where('status', $search['status']);
        }

        return $query;
    }

    protected function emailVerifiedAt(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null,
            set: fn($value) => $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->hasRole(1),
        );
    }

    public static function getUserViaRole($role)
    {
        return self::whereHas('roles', function ($query) use ($role): void {
            $query->whereId($role);
        })->get();
    }

    public static function getUserViaExceptRole($role)
    {
        return self::whereHas('roles', function ($query) use ($role): void {
            $query->where('id','!=',$role);
        })->get();
    }

    public function getRoleName()
    {
        return self::with(['roles'])->first()->name;
    }
}
