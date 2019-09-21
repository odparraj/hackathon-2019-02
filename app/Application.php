<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //

    protected $with = [
        "status"
    ];




    public function status()
    {
        return $this->belongsTo(ApplicationState::class, 'id_status');
    }
}
