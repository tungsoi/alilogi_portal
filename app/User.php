<?php

namespace App;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Encore\Admin\Auth\Database\HasPermissions;
use App\Models\System\Province;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, AdminBuilder, HasPermissions;

    const STATUS = [
        0   =>  'Khoá',
        1   =>  'Hoạt động'
    ];

    const ADMIN = 0;
    const CUSTOMER = 1;
    const ACTIVE = 1;
    const DEACTIVE = 0;

    const STAFF_SALE_ROLE_ID = 3;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "admin_users";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'avatar',
        'email',
        'phone_number',
        'wallet',
        'address',
        'is_customer',
        'symbol_name',
        'ware_house_id',
        'is_active',
        'password',
        'note',
        'wallet_order',
        'province',
        'district',
        'staff_sale_id',
        'customer_percent_service',
        'type_customer',
        'is_updated_profile'
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []){
        $connection = $this->connection ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar){
        if(url()->isValidUrl($avatar)){
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if($avatar && array_key_exists($disk, config('filesystems.disks'))){
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/bamboo-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return admin_asset($default);
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany{
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany{
        $pivotTable = config('admin.database.user_permissions_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }

    public function getAccessToken(){
        $token = json_decode($this->token, true);
        if($token && isset($token['access_token'])){
            return $token['access_token'];
        }
        return '';
    }

    public function warehouse() {
        return $this->hasOne('App\Models\System\Warehouse', 'id', 'ware_house_id');
    }

    public static function customers() {
        return self::where('is_customer', 1)->get();
    }

    public function saleStaff()
    {
        # code...
        return $this->hasOne(User::class, 'id', 'staff_sale_id');
    }
}
