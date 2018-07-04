<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\Traits\ModelForm;
use App\Admin\Grid;
use App\Admin\Facades\Admin;
use App\Admin\Form;
use App\Admin\Layout\Content;
use App\Models\Miner;
use App\Models\Worker;

class WorkerController
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
            $content->header('Worker資訊');
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
            $content->header('Worker資訊');
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
            $content->header('Worker資訊');
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }
    public function grid()
    {
        return Admin::grid(Worker::class, function (Grid $grid) {
            $grid->column('miner.alias', 'Miner別名');
            $grid->alias('別名')->editable();
            $grid->enable('推播')->switch(['on' => ['value' => 1, 'text' => '啟用', 'color' => 'success'], 'off' => ['value' => 0, 'text' => '停用', 'color' => 'default']]);
            $grid->column('miner.miner', 'Miner');
            $grid->targetHashrate('目標算力')->editable();
            $grid->worker('Worker')->editable();
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            // 篩選設定
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->equal('miner_id', 'Miner')->select(Miner::all()->pluck('miner', 'id'));
                $filter->like('miner.alias', 'Miner別名');
                $filter->like('alias', '別名');
            });

            // 操作設定
            $grid->actions(function (Grid\Displayers\Actions $actions) {

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
        return Admin::form(Worker::class, function (Form $form) {
            $form->select('miner_id', 'Miner')->options(Miner::all()->pluck('miner', 'id'))->rules('required');
            $form->text('alias', '別名');
            $form->text('targetHashrate', '目標算力')->rules('required');
            $form->text('worker', 'Worker')->rules('required');
            $form->switch('enable', '推播')->states(['on' => ['value' => 1, 'text' => '啟用', 'color' => 'success'], 'off' => ['value' => 0, 'text' => '停用', 'color' => 'default']]);
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
