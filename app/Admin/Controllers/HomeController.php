<?php

namespace App\Admin\Controllers;

use App\Admin\Widgets\InfoBox;
use App\Http\Controllers\Controller;
use App\Admin\Facades\Admin;
use App\Admin\Layout\Column;
use App\Admin\Layout\Content;
use App\Admin\Layout\Row;
use App\Models\Group;
use App\Models\Miner;
use App\Models\User;
use App\Models\Worker;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Ethermine 管理平台');
            $content->description('Dashboard');

            $content->row(function ($row) {
                $row->column(3, new InfoBox('會員', 'users', 'green', '/admin/user', User::all()->count()));
                $row->column(3, new InfoBox('API發送群組', 'send', 'red', '/admin/group', Group::all()->count()));
                $row->column(3, new InfoBox('Miner', 'btc', 'aqua', '/admin/miner', Miner::all()->count()));
                $row->column(3, new InfoBox('Worker', 'hdd-o', 'yellow', '/admin/worker', Worker::all()->count()));
            });
        });
    }
}
