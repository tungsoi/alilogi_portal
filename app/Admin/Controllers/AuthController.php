<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use App\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use App\Models\System\Warehouse;
use App\Models\Province;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseAuthController
{
    /**
     * Update profile when user login into system
     */
    public function updateProfile(Request $request)
    {
        User::find(Admin::user()->id)->update([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "ware_house_id" => $request->warehouse_id,
            "province" => $request->province_id,
            "district" => $request->district_id,
            "address" => $request->address,
            "staff_sale_id" => $request->staff_sale_id,
            'is_updated_profile'    =>  1
        ]);

        admin_toastr(trans('admin.save_succeeded'));
        return redirect()->route('admin.home');
    }

     /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $form = $this->settingForm();
        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
                $tools->disableDelete();
                $tools->disableView();
            }
        );

        $form->disableEditingCheck();

        $form->disableCreatingCheck();

        $form->disableViewCheck();

        return $content
            ->title(trans('admin.user_setting'))
            ->body($form->edit(Admin::user()->id));
    }

     /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        $class = config('admin.database.users_model');

        $form = new Form(new $class());

        $form->display('username', "Tên đăng nhập / Email");
        $form->display('symbol_name', 'Mã khách hàng');
        $form->divider();
        $form->text('name', trans('admin.name'))->rules('required');
        $form->text('phone_number', 'Số điện thoại')->rules('required');
        $form->image('avatar', trans('admin.avatar'));
        $form->select('ware_house_id', 'Kho nhận hàng')->options(Warehouse::all()->pluck('name', 'id'))->rules('required');
        $form->select('province', 'Tỉnh / Thành phố')->options(Province::all()->pluck('name', 'province_id'))->rules('required');
        $form->select('district', 'Quận / Huyện')->options(District::all()->pluck('name', 'district_id'))->rules('required');

        $ids = DB::table(config('admin.database.role_users_table'))->where('role_id', User::STAFF_SALE_ROLE_ID)->get()->pluck('user_id');
        $form->select('staff_sale_id', 'Nhân viên kinh doanh')->options(User::whereIn('id', $ids)->get()->pluck('name', 'id'))->rules('required');
        $form->text('address', 'Địa chỉ')->rules('required');

        $form->password('password', trans('admin.password'))->rules('confirmed|required');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->setAction(admin_url('auth/setting'));

        $form->ignore(['password_confirmation']);

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        $form->saved(function () {
            admin_toastr(trans('admin.update_succeeded'));

            return redirect(admin_url('auth/setting'));
        });

        return $form;
    }

}
