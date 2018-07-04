<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\Traits\ModelForm;
use App\Admin\Grid;
use App\Models\AdminConfig;
use App\Admin\Facades\Admin;
use App\Admin\Form;
use App\Admin\Layout\Content;
use App\Models\Group;
use App\Models\Miner;

class GroupController
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('API發送群組');
            $content->description(trans('admin.list'));
            $content->body($this->grid());
        });
    }
    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('API發送群組');
            $content->description(trans('admin.edit'));
            $content->body($this->form()->edit($id));
        });
    }
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('API發送群組');
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }
    public function grid()
    {
        return Admin::grid(Group::class, function (Grid $grid) {
            $grid->name(trans('admin.name'));
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            // 操作設定
            $grid->actions(function (Grid\Displayers\Actions $actions) {

            });

            // 工具設定
            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });

            $grid->disableFilter();
            $grid->disableExport();
        });
    }
    public function form()
    {
        return Admin::form(Group::class, function (Form $form) {
            $form->text('name', trans('admin.name'))->rules('required');
            $form->listbox('miners', 'Miner')->options(Miner::all()->pluck('miner', 'id'));
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
