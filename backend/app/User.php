<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ownsTopic(Topic $topic) {
        return $this->id === $topic->user->id;
    }

    public function ownsPost(Post $post) {
        return $this->id === $post->user->id;
    }

    public function hasLikedPost(Post $post) {
        return $post->likes->where('user_id', $this->id)->count() === 1;
    }

    public function getJWTIdentifier()
    {
        // Return the primary key of the user - user id
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Return a key value array, containing any custom claims to be added to JWT
        return [];
    }


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
