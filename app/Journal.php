<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\User;
use App\Category;

class Journal extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    use notifiable;

    public const APPROVED = "Approved";
    public const WAITING = "Waiting";
    public const REJECTED = "Rejected";
    public const PENDING = "Pending";
    public const PENDING_PAYMENT = "Pending Payment";

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
        return $this->morphToMany(Category::class, 'categorizable')->withTimestamps();
    }

    /**
     * Get the reviewer for the journal.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include approved journals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', Journal::APPROVED);
    }

    /**
     * Scope a query to only include waiting journals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWaiting($query)
    {
        return $query->where('status', Journal::WAITING);
    }

    /**
     * Scope a query to only include Rejected journals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', Journal::REJECTED);
    }

    /**
     * Scope a query to only include Pending journals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', Journal::PENDING);
    }

        /**
     * Scope a query to only include Pending payment journals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', 0);
    }

}
