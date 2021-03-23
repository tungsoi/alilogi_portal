<?php

namespace App\Models\System;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRate
 *
 * @package App\Models
 */
class ExchangeRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vnd', 'ndt', 'is_active'];

    /**
     * Get current rate
     * @return float|int
     */
    public function getCurrentRate()
    {
        return (float)$this->vnd / (float)$this->ndt;
    }
}
