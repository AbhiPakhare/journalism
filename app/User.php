<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The role that belong to the user.
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Role::class);
    }

    /**
     * Get all of the categories for the user.
     */
    public function categories(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable')->withTimestamps();
    }

    /**
     * Get the journals for the user.
     */
    public function journal()
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Get the assigned journals for the reviewer post.
     */
    public function assignedJournal()
    {
        return $this->hasMany(Journal::class, 'reviewer_id','id');
    }

    //Get Phone Number for user
    public function phone()
    {
        return $this->hasOne(Phone::class);
    }




}
