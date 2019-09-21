<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationState extends Model
{
    protected $connection = 'mysql2';
    public $table = "applications_status";
}
