<?php

namespace App\Models;


class Meeting extends BaseCascadeModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendees',
        'objectives',
        'notes',
        'action_items',
    ];

    /**
     * Get the meeting's item.
     */
    public function hubItems()
    {
        return $this->morphOne('App\Models\HubItem', 'hub_itemable');
    }

    /**
     * Get the meeting's item.
     */
    public function files()
    {
        return $this->morphMany('App\Models\HubFile', 'hub_fileable');
    }
}
