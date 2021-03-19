<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * Table name
     */
    protected $table = 'provinces';

    /**
     * Fields
     */
    protected $fillable = [
        'province_id',
        'name',
        'type'
    ];
}
