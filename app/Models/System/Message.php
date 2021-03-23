<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "messages";

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'title', 'content'];

    public function customer() {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
}
