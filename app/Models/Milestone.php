<?php

namespace App\Models;

class Milestone extends BaseCascadeModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id'
    ];

    /**
     * Get the milestone's item.
     */
    public function hubItems()
    {
        return $this->morphOne('App\Models\HubItem', 'hub_itemable');
    }

    /**
     * Get the milestone's files.
     */
    public function files()
    {
        return $this->morphMany('App\Models\HubFile', 'hub_fileable');
    }
}
