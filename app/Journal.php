<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Journal extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    use notifiable;

    public const APPROVED = "Approved";
    public const WAITING = "Waiting";
    public const REJECTED = "Rejected";

    protected $fillable = ['user_id','reference_id'];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the categories for the journal.
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categorizable')->withTimestamps();
    }

    /**
     * Get the reviewer that has the journal.
     */
    public function reviewer()
    {
        return $this->belongsTo('App\User');
    }

}
