<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\User;
use App\Util\Traits\HasPagination;
use Illuminate\Support\Facades\DB;

class QuerylecController extends PageController
{
    use HasPagination;

    public function index()
    {
        $this->onPaginationIndex();

        $items = User::where('status_lector',0)->paginate(self::DEFAULT_PAGE_SIZE);
        $items1 = User::where('status_lector',1)->paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.querylec', [
            'items' => $items,
            'items1' => $items1,
        ]);
    }

    public function view($id)
    {
        $item = User::findOrFail($id);
        return view('admin.userView', [
            'item' => $item
        ]);
    }

    public function delLec($id)
    {
        $item = User::findOrFail($id);
        if ($item->isAdmin()) {
            throw new \LogicException("Can't delete admin");
        }
        $affected = DB::table('users')
              ->where('id', $id)
              ->update(['status_lector' => NULL]);
        return back();
    }

    public function addLec($id)
    {
        $item = User::findOrFail($id);
        if ($item->isAdmin()) {
            throw new \LogicException("Can't delete admin");
        }
        $affected = DB::table('users')
              ->where('id', $id)
              ->update(['status_lector' => 1]);
        return back();
    }

}
