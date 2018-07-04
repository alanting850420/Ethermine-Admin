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

class UserController
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
            $content->header('User資訊');
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
            $content->header('User資訊');
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
            $content->header('User資訊');
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }
    public function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->email(trans('admin.username'));
            $grid->name(trans('admin.name'))->editable();
            $grid->column('miners_count', 'Miner數量')->display(function (){
                return Miner::where('user_id', $this->id)->count();
            });
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            // 篩選設定
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('email', trans('admin.username'));
                $filter->like('name', trans('admin.name'));
            });

            // 操作設定
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->prepend('<a href="' .config('url') .'/admin/miner?&user_id=' .$this->getKey().'"><i class="fa fa-external-link"></i></a>');
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
        return User::form(function (Form $form) {
            $form->email('email', trans('admin.username'))->rules('required');
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);
            $form->text('name', trans('admin.name'))->rules('required');
            $form->text('access_token', 'Line Token');
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));

            //儲存前設定
            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
