<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $connection = 'mysql2';
    protected $with = [
        //"applications"
    ];







    public function applications()
    {
        return $this->hasMany(Application::class, 'id_contact');
    }
}
