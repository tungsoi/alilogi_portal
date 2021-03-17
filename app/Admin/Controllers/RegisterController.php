<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends AdminController
{
    public function getRegister()
    {
        return view('admin.register');
    }

    public function postRegister(Request $request)
    {
        $this->registerValidator($request->all())->validate();

        dd('oke');
        $credentials = $request->only([$this->username(), 'password']);
        $remember = $request->get('remember', false);

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);

        dd($request->all());
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
            $this->username()   => 'required|email'
        ],[
            'username.required' =>  'Vui lòng nhập địa chỉ Email',
            'username.email'    =>  'Vui lòng nhập đúng định dạng Email'
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
}
