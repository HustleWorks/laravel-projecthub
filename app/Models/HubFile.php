<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubFile extends Model
{

    protected $storage_path = '/storage/hub/files/';

    public function getStoragePath(){
        return $this->storage_path;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'size',
        'fileable_id',
        'fileable_type',
    ];

    /**
     * Get all of the owning fileable models.
     */
    public function hubFileable()
    {
        return $this->morphTo();
    }
}
