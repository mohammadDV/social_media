<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'mobile',
        'biography',
        'profile_photo_path',
        'bg_photo_path',
        'national_code',
        'point',
        'role_id',
        'status',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */


    protected $visible = [
        'id','first_name','last_name','nickname', 'clubs','biography','profile_photo_path','bg_photo_path','point','role_id', 'email', 'status', 'created_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function following()
    {
        return $this->hasMany(Follow::class,'follower_id');
    }

    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'favorite_clubs','user_id', 'club_id')->with('sport', 'country');
    }

    public function getFullNameAttribute()
    {
        return !empty($this->nickname) ? $this->nickname : "{$this->first_name} {$this->last_name}";
    }

    public function getStatusNameAttribute()
    {
        return $this->status == 1 ? __('site.Active') : __('site.Inactive');
    }
}
