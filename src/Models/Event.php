<?php

namespace Acacha\Events\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event.
 *
 * @package Acacha\Events\Models
 */
class Event extends Model
{
    protected $fillable = ['name','description'];

//    protected $guarded = [''];
}
