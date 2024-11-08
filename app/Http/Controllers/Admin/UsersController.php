<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\User;
use App\Util\Export\UserToExcelConverter;
use App\Util\Traits\HasPagination;
use App\Util\UploadsDir\PrivateUploadsDir;

class UsersController extends PageController
{
    use HasPagination;

    public function index()
    {
        $this->onPaginationIndex();

        $items = User::paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.users', [
            'items' => $items
        ]);
    }

    public function view($id)
    {
        $item = User::findOrFail($id);
        return view('admin.userView', [
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);
        if ($item->isAdmin()) {
            throw new \LogicException("Can't delete admin");
        }
        $item->delete();
        return back();
    }

    public function exportAll()
    {
        $uploads = new PrivateUploadsDir('users');
        $name = $uploads->generateName('xlsx');
        $path = $uploads->getPathFor($name);

        $users = User::where('type', '!=', User::ADMIN_TYPE)
            ->get();

        UserToExcelConverter::exportAll($users, $path);

        return response()
            ->download($path)
            ->deleteFileAfterSend();
    }
}
