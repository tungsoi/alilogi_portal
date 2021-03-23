<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class ScheduleLog extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "schedule_logs";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = ['code'];
}
