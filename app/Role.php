<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    public const ADMIN = "Admin";
    public const MANAGER = "Manager";
    public const REVIEWER = "Reviewer";
    public const USER = "User";

    protected $fillable = ['name','user_id'];


    /**
     * The user that belong to the role.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Scope a query to only include users with reviewer role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReviewer($query)
    {
        return $query->where('name', Role::REVIEWER);
    }

    /**
     * Scope a query to only include users with Manager role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManager($query)
    {
        return $query->where('name', Role::MANAGER);
    }

    /**
     * Scope a query to only include users with User role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUser($query)
    {
        return $query->where('name', Role::USER);
    }
}
