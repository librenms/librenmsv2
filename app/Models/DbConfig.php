<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DbConfig extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'config_id';

    public function scopeKey($query, $key)
    {
        return $query->where('config_name', 'LIKE', $key . '%');
    }

    public function scopeExactKey($query, $key)
    {
        return $query->where('config_name', $key);
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
