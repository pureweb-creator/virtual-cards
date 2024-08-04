<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'google_id',
        'google_token',
        'google_refresh_token',
        'first_name',
        'last_name',
        'home_tel',
        'work_tel',
        'website',
        'avatar',
        'email',
        'email_verified_at',
        'company',
        'job_title',
        'user_hash',
        'invoice_id',
        'is_subscribed',
        'trial_expiration_time',
        'expiration_time',
        'password',
        'remember_token',
        'location_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'expiration_time' => 'datetime',
            'trial_expiration_time' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function socialNetworks()
    {
        return $this->belongsToMany(SocialNetwork::class)
            ->withPivot('link')
            ->withPivot('hidden')
            ->withTimestamps();
    }

    public function locations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Locations::class);
    }
}
