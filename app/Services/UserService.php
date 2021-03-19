<?php

namespace App\Services;

use App\User;

class UserService
{
    public function createCustomerCode()
    {
        $prefix = "MKH";

        $users = User::whereNotNull('symbol_name')->whereIsActive(User::ACTIVE)->orderBy('id', 'desc')->get();
    }
}
