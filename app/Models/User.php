<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'expired_at', 'user_id', 'avatar', 'display_name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The Carbon instances
     *
     * @var array
     */
    protected $dates = ['expired_at'];

    /**
     * Detect if the user membership has expired
     *
     * @return bool
     */
    public function membershipExpired()
    {
        return $this->expired_at < Carbon::now();
    }

    /**
     * Detect if the user can manage
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->role == "administrator";
    }

    /**
     * Get the user's projects collection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    /**
     * Change a user's role
     *
     * @return string
     */
    public function changeRole()
    {
        $this->role = $this->role == "member" ? "administrator" : "member";
        $this->save();

        return $this->role == "member" ? $this->name."已被取消管理员" : $this->name."已成为管理员";
    }

    /**
     * Search users by certain keywords
     *
     * @param $keywords
     * @return mixed
     */
    public static function search($keywords)
    {
        $users = User::where('name', 'like', '%' . $keywords . '%')
                    ->orWhere('display_name', 'like', '%' . $keywords . '%')
                    ->distinct()
                    ->paginate(30);

        return $users;
    }

    /**
     * Local scope for managers first
     *
     * @param $query
     * @return mixed
     */
    public static function scopeManagersFirst($query)
    {
        return $query->orderBy('role', 'desc');
    }

    /**
     * Get the avatar image source
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        $avatar = $this->attributes["avatar"];

        if (!str_contains($avatar, 'https://')) {
            $avatar = str_replace('http', 'https', $avatar);
        }

        return $avatar;
    }
}
