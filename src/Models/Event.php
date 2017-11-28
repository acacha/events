<?php

namespace Acacha\Events\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event.
 *
 * @package Acacha\Events\Models
 */
class Event extends Model
{
    protected $fillable = ['name','description','user_id'];

    /**
     * Get the user that belongs the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function user() {
        return $this->belongsTo(User::class);
    }
}
