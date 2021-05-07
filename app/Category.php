<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];


    /**
     * Get all of the reviewer that are assigned this categories.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'categorizable');
    }

    /**
     * Get all of the journals that are assigned this categories.
     */
    public function journals()
    {
        return $this->morphedByMany('App\Journal', 'categorizable');
    }
}
