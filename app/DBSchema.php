<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DBSchema extends Model
{
    protected $table = 'dbSchema';
    protected $primaryKey = false;
    public $timestamps = false;
}
