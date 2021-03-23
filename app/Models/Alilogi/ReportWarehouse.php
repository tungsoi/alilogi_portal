<?php

namespace App\Models\Alilogi;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class ReportWarehouse extends Model
{
    use AdminBuilder;

    const LINE = [
        'BAO',
        'KIỆN'
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "report_warehouses";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'order',
        'title',
        'weight',
        'lenght',
        'width',
        'height',
        'cublic_meter',
        'line',
        'transport_route',
        'warehouse_id',
        'note'
    ];

    public function details() {
        return $this->hasMany('App\Models\Alilogi\ReportWarehouse', 'id', 'id');
    }

    public function transportRoute() {
        return $this->hasMany('App\Models\System\TransportRoute', 'id', 'transport_route');
    }

    public function warehouse() {
        return $this->hasOne('App\Models\System\Warehouse', 'id', 'warehouse_id');
    }
}
