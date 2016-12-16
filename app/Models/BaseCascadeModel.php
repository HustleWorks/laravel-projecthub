<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class BaseCascadeModel extends Model
{
    public static function boot() {
        parent::boot();

        static::deleting(function($model) { // before delete() method call this

            foreach ($model->files as $f){
                File::delete(public_path().$f->getStoragePath().$f->name);
            }
            $model->files()->delete();
            $model->hubItems()->delete();
        });
    }

}
