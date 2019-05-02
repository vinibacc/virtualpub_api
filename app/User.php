<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'token', 'sobre', 'fabricante_name', 'website',
        'avatar', 'password', 'provider_id', 'provider',
        'access_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isMantenedor', 'isUser', 'isFabricante',
    ];

    /**
     *
     *
     *
     */
    public function isMantenedor()
    {
        return $this->isMantenedor;
    }

    /**
     *
     *
     *
     */
    public function isFabricante()
    {
        return $this->isFabricante;
    }

    /**
     *
     *
     *
     */
    public function isUser()
    {
        return $this->isUser;
    }

    /**
     *
     *
     *
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    /**
     *
     *
     *
     */
    public function getAvatarAttribute($val)
    {
        return is_null($val) ? asset('images/avatar-placeholder.svg') : $val;
    }

    /**
     *
     *
     *
     */
    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'amizades', 'seguidor_id', 'user_id')->withTimestamps();
    }

/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'amizades', 'user_id', 'seguidor_id')->withTimestamps();
    }

    public function favoritas()
    {
        return $this->belongsToMany(Cerveja::class, 'cervejas_favoritas', 'user_id', 'cerveja_id')->withTimestamps();
    }

/**
 * Return the user attributes.

 * @return array
 */
    public static function getAuthor($id)
    {
        $user = self::find($id);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'url' => '', // Optional
            'avatar' => $user->avatar, // Default avatar
            'admin' => $user->isMantenedor(),
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function cervejas()
    {
        return $this->hasMany(Cerveja::class);
    }

}
