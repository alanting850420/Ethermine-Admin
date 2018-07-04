<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\Traits\ModelForm;
use App\Admin\Grid;
use App\Models\AdminConfig;
use App\Admin\Facades\Admin;
use App\Admin\Form;
use App\Admin\Layout\Content;
use App\Models\Miner;
use App\Models\User;

class MinerController
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
            $content->header('Miner資訊');
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
            $content->header('Miner資訊');
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
            $content->header('Miner資訊');
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }
    public function grid()
    {
        return Admin::grid(Miner::class, function (Grid $grid) {
            $grid->column('user.name', 'User');
            $grid->alias('別名')->editable();
            $grid->miner('Miner')->editable();
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            // 篩選設定
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->equal('user_id', 'User')->select(User::all()->pluck('name', 'id'));
                $filter->like('alias', '別名');
                $filter->like('miner', 'Miner');
            });

            // 操作設定
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->prepend('<a href="' .config('url') .'/admin/worker?miner_id=' .$this->getKey().'"><i class="fa fa-external-link"></i></a>');
            });

            // 工具設定
            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });

            $grid->disableExport();
        });
    }
    public function form()
    {
        return Admin::form(Miner::class, function (Form $form) {
            $form->select('user_id', 'User')->options(User::all()->pluck('name', 'id'))->rules('required');
            $form->text('alias', '別名');
            $form->text('miner', 'Miner')->rules('required');
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
