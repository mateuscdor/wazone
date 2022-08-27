<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Impersonate;

    public function autoreplies()
    {
        return $this->hasMany(Autoreply::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function package()
    {
      return $this->belongsTo(Package::class);
    }

    public function outboxes()
    {
        return $this->hasMany(Outbox::class);
    }

    public function phonebooks()
    {
        return $this->hasMany(Phonebook::class);
    }

    public function blocked()
    {
        return $this->hasMany(Blocked::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'lang',
        'theme',
        'package_id',
        'trial_period',
        'billing_interval',
        'billing_start',
        'billing_end',
        'current_sent',
        'total_sent',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
