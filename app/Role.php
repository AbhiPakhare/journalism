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

    /*
     * get user for this role
     * */
    /**
     * The user that belong to the role.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
