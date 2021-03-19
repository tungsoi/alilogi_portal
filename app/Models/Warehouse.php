<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "ware_houses";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'is_active'];
}
