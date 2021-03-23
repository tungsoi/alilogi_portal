<?php

namespace App\Admin\Controllers\System;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\System\Message;
use App\User;
use Encore\Admin\Facades\Admin;

class MessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = 'Hòm thư góp ý';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Message);
        if (Admin::user()->isRole('customer')) {
            $grid->model()->where('customer_id', Admin::user()->id);
            $grid->disableExport();
        }

        $grid->filter(function($filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->like('title', trans('admin.title'));
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');

        $grid->customer_id('Khách hàng')->display(function () {
            return $this->customer->name." - ".$this->customer->symbol_name;
        });
        $grid->title('Tiêu đề');
        $grid->content('Nội dung');

        $grid->created_at(trans('admin.created_at'))->display(function () {
            return date('H:i | d-m-Y', strtotime($this->created_at));
        });
        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            // $actions->disableView();
            // $actions->disableEdit();
            $actions->disableDelete();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Message::findOrFail($id));

        $show->field('id', trans('admin.id'));
        $show->title('Tiêu đề');
        $show->customer_id('Khách hàng tạo')->as(function () {
            return $this->customer->symbol_name ?? "";
        });
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            // $tools->disableList();
            $tools->disableDelete();
        });;

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Message);

        $form->text('title', 'Tiêu đề')->rules('required');
        $form->textarea('content', 'Nội dung')->rules('required');
        $form->hidden('customer_id')->default(Admin::user()->id);

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            // $tools->disableView();
            // $tools->disableList();
        });

        return $form;
    }


}
