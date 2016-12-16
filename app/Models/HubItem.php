<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubItem extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'hub_itemable_id', 'hub_itemable_type',
    ];

    /**
     * Get all of the owning HubItemable models.
     */
    public function hubItemable()
    {
        return $this->morphTo();
    }
}
