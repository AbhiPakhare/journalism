<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Journal extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    
    public const APPROVED = "Approved";
    public const WAITING = "Waiting";
    public const REJECTED = "Rejected";

    protected $fillable = ['user_id','reference_id'];

}
