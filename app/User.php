<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'allowed',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function socials()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class);
    }

    public function hasRole($name)
    {
        // TODO: caching
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);
                if ($hasRole) {
                    return true;
                }
            }
        } else {
            foreach ($this->roles()->get() as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isAllowed()
    {
        return $this->allowed;
    }

    public function getCurrentSocialProvider()
    {
        return $this->socials()->orderBy('updated_at', 'desc')->first();
    }

    public function loadWorker()
    {
        $this->setRelation('worker', $this->workers->first());
    }

    public function getWorkerAttribute()
    {
        if (! array_key_exists('worker', $this->relations)) {
            $this->loadWorker();
        }

        return $this->getRelation('worker');
    }
}
