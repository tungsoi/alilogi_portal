<?php

namespace App\Models\Alilogi;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;

class Post extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "posts";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id_created'
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id_created');
    }
}
