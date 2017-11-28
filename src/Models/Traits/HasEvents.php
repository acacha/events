<?php

namespace Acacha\Events\Models\Traits;

use Acacha\Events\Models\Event;

/**
 * Trait HasEvents.
 */
trait HasEvents
{
    /**
     * Get the events associated to the model
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}