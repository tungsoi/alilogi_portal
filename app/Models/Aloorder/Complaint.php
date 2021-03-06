<?php

namespace App\Models\Aloorder;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "complaints";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'order_id',
        'image',
        'item_name',
        'item_price',
        'content',
        'status'
    ];

    const STATUS = [
        self::NEW   =>  self::NEW_TEXT,
        self::PROCESS_NORMAL   =>  self::PROCESS_NORMAL_TEXT,
        self::PROCESS_AGENT    =>  self::PROCESS_AGENT_TEXT,
        self::ADMIN_CONFIRM_SUCCESS =>  self::ADMIN_CONFIRM_SUCCESS_TEXT,
        self::CUSTOMER_CONFIRM_SUCCESS =>  self::CUSTOMER_CONFIRM_SUCCESS_TEXT,
        self::DONE  =>  self::DONE_TEXT
    ];

    const NEW = 0;
    const NEW_TEXT = "Khuyếu nại mới";

    const PROCESS_NORMAL = 1;
    const PROCESS_NORMAL_TEXT = "Đang xử lý";

    const PROCESS_AGENT = 2;
    const PROCESS_AGENT_TEXT = "Đang xử lý (Gấp)";

    const ADMIN_CONFIRM_SUCCESS = 3;
    const ADMIN_CONFIRM_SUCCESS_TEXT = "Admin xác nhận xử lý khuyếu nại thành công";

    const CUSTOMER_CONFIRM_SUCCESS = 4;
    const CUSTOMER_CONFIRM_SUCCESS_TEXT = "Khách hàng xác nhận xử lý khuyếu nại thành công";

    const DONE = 5;
    const DONE_TEXT = "Hoàn thành";

    const LABEL = [
        'default',
        'warning',
        'danger',
        'info',
        'primary',
        'success'
    ];

    public function setImageAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['image'] = json_encode($pictures);
        }
    }

    public function getImageAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

    public function order() {
        return $this->hasOne(PurchaseOrder::class, 'id', 'order_id');
    }

    public function customer() {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
