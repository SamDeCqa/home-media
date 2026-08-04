<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** This assigns uuid to the models having the uuid column in their respective DB Tables */
class UuidObserver
{
    public function creating (Model $model) {
        if(empty($model->uuid)){
            $model->uuid = Str::uuid();
        }
    }
    
   /* public function saving (Model $model) {
        if(empty($model->uuid)){
            $model->uuid = Str::uuid();
        }
    }
        */
}
