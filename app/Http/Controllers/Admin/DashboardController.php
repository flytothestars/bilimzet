<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Gid;

class DashboardController extends PageController
{
    public function index() {
        return redirect()->route('admin.users');
    }
}
