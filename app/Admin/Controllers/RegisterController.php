<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class RegisterController extends AdminController
{
    public function getRegister()
    {
        return view('admin.register');
    }

    public function postRegister(Request $request)
    {
        $this->registerValidator($request->all())->validate();

        $email = $request->username;

        $dataRegister = [
            'username'  =>  $email,
            'name'      =>  $email,
            'avatar'    =>  NULL,
            'email'     =>  $email,
            'phone_number'  =>  NULL,
            'wallet'    =>  0,
            'address'   =>  NULL,
            'is_customer'   =>  1,
            'ware_house_id' =>  NULL,
            'is_active'     =>  1,
            'password'      =>  Hash::make('123456'),
            'note'          =>  NULL,
            'province'  =>  0,
            'district'  =>  0,
            'staff_sale_id' =>  NULL,
            'customer_percent_service'  =>  1,
            'type_customer' =>  NULL,
            'is_updated_profile'    =>  0
        ];

        $user = User::create($dataRegister);

        DB::table('admin_role_users')->insert([
            'role_id'   =>  2,
            'user_id'   =>  $user->id
        ]);

        $user->symbol_name = 'MKH'.str_pad($user->id, 4, 0);
        $user->save();

        $credentials = [
            'username'  =>  $email,
            'password'  =>  '123456'
        ];
        $remember = true;

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registerValidator(array $data)
    {
        return Validator::make($data, [
            $this->username()   => 'required|email|unique:admin_users'
        ],[
            'username.required' =>  'Vui l??ng nh???p ?????a ch??? Email.',
            'username.email'    =>  'Vui l??ng nh???p ????ng ?????nh d???ng Email (VD: nguyenvantuan@gmail.com).',
            'username.unique'   =>  'Email n??y ???? ???????c ????ng k?? tr??n h??? th???ng, vui l??ng s???a d???ng email kh??c.'
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Admin::guard();
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        admin_success("????ng k?? t??i kho???n th??nh c??ng", 'Ch??o m???ng b???n ???? tr??? th??nh kh??ch h??ng c???a ALILOGI.');

        admin_toastr(trans('admin.login_successful'));

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }
}
