<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
     * Table name
     */
    protected $table = 'districts';

    /**
     * Fields
     */
    protected $fillable = [
        'district_id',
        'name',
        'type',
        'location',
        'province_id'
    ];
}
