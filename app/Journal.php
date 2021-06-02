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

    protected $fillable = [
		'user_id',
		'reviewer_id',
		'reference_id',
		'status',
		'reason',
		'payment_status',
		'payment_link',
		'final_document_status'
	];

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
        return $query->where('status', Journal::PENDING_PAYMENT);
    }

	/**
     * Get the Journal journey status.
     *
     * @return string
     */
    public function getJourneyStatusAttribute()
    {
		if(is_null($this->reviewer_id) ){
			return [
				'stage' => 0,
				'stage_name' =>"Submitted"
			];
		}elseif(! is_null($this->reviewer_id) && ! in_array($this->status, ['Rejected', 'Approved', 'Pending Payment','Pending'])) {
			return [
				'stage' => 1,
				'stage_name' =>"Checking Process"
			];

		}elseif($this->status == "Waiting" && ! is_null($this->reviewer_id)) {

			return [
				'stage' => 2,
				'stage_name' =>"Waiting"
			];

		}elseif($this->status == "Pending"){

			return [
				'stage' => 2,
				'stage_name' =>"Pending"
			];
			
		}elseif($this->status == "Rejected"){

			return [
				'stage' => 2,
				'stage_name' =>"Rejected"
			];
			
		}elseif ($this->status == "Pending Payment" && ! $this->payment_status) {
			return [
				'stage' => 3,
				'stage_name' =>"Pending"
			];
		}elseif($this->status == "Approved" && $this->payment_status && !$this->final_document_status) {
			return [
				'stage' => 3,
				'stage_name' =>"Done"
			];
		}elseif($this->status == "Approved" && $this->payment_status && $this->final_document_status){
			return [
				'stage' => 4,
				'stage_name' => "Final document submitted"
			];
		}
    }
}
