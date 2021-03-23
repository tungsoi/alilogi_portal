<?php

namespace App\Admin\Controllers\System;

use App\Models\Alilogi\ReportWarehouse;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\System\TransportRoute;
use Encore\Admin\Facades\Admin;

class TransportRouteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = 'Line vận chuyển';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TransportRoute);

        $grid->filter(function($filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->like('title', trans('admin.title'));
        });
        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');
        $grid->title(trans('admin.title'));
        $grid->created_at(trans('admin.created_at'))->display(function () {
            return date('H:i | d-m-Y', strtotime($this->created_at));
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
        $grid = new Grid(new ReportWarehouse());

        $grid->model()->select('date')->groupBy('date')->orderBy('date', 'desc');

        $grid->filter(function($filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->between('date', "Ngày")->date();
        });

        $grid->header(function ($query) use ($id) {
            return "<h3>Line " . TransportRoute::find($id)->title."</h3>";
        });
        $routes = TransportRoute::where('id', $id)->get();

        $grid->column('date',"Ngày")->totalRow(function () {
            return "-";
        });
        $grid->column('total', 'Số lượng')->display(function () use ($routes) {

            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereIn('line', [0, 1])
                ->whereTransportRoute($route->id)
                ->count();
                $total += $content;

                $html .= "<span class='sum_total'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('weight', 'Tổng KG')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->sum('weight');
                $total += $content;

                $html .= "<span class='sum_weight'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('cublic_meter', 'Tổng M3')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->sum('cublic_meter');
                $total += $content;

                $html .= "<span class='sum_cublic_meter'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('box', 'Số bao')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 0)->count();
                $total += $content;

                $html .= "<span class='sum_box'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('kg_box', 'Số KG bao')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 0)
                ->sum('weight');
                $total += $content;

                $html .= "<span class='sum_kg_box'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('m3_box', 'M3 bao')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 0)
                ->sum('cublic_meter');
                $total += $content;

                $html .= "<span class='sum_m3_box'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('package', 'Số kiện')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 1)
                ->count();
                $total += $content;

                $html .= "<span class='sum_package'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('kg_package', 'Số KG kiện')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 1)
                ->sum('weight');
                $total += $content;

                $html .= "<span class='sum_kg_package'>".$content."</span>";
            }

            return $html;
        });
        $grid->column('m3_package', 'M3 kiện')->display(function () use ($routes) {
            $html = "";
            $total = 0;
            foreach ($routes as $route) {
                $content = ReportWarehouse::where('date', $this->date)
                ->whereTransportRoute($route->id)
                ->where('line', 1)
                ->sum('cublic_meter');
                $total += $content;

                $html .= "<span class='sum_m3_package'>".$content."</span>";
            }

            return $html;
        });

        // setup
        $grid->paginate(20);
        $grid->disableActions();

            Admin::script(
                <<<EOT

                $('tfoot').each(function () {
                    $(this).insertAfter($(this).siblings('thead'));
                });

                $( document ).ready(function() {
                    $('tfoot .column-date').html("");

                    $('tfoot .column-total').html(getTotal('sum_total', 0));
                    $('tfoot .column-weight').html(getTotal('sum_weight', 1));
                    $('tfoot .column-cublic_meter').html(getTotal('sum_cublic_meter'));
                    $('tfoot .column-box').html(getTotal('sum_box', 0));
                    $('tfoot .column-kg_box').html(getTotal('sum_kg_box', 2));
                    $('tfoot .column-m3_box').html(getTotal('sum_m3_box'));
                    $('tfoot .column-package').html(getTotal('sum_package', 0));
                    $('tfoot .column-kg_package').html(getTotal('sum_kg_package', 2));
                    $('tfoot .column-m3_package').html(getTotal('sum_m3_package'));
                });

                function getTotal(cl, prefix = 4) {
                    let obj = $('tbody .'+cl);

                    let total = 0;
                    obj.each( function( i, el ) {
                        var elem = $( el );
                        let html = parseFloat($.trim(elem.html()));
                        total += html;
                    });
                    total = total.toFixed(prefix);

                    return total;
                }
EOT
    );

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TransportRoute);

        $form->display('id', __('ID'));
        $form->text('title', trans('admin.title'))->rules('required');
        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        return $form;
    }
}
