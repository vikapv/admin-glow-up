<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserStatusRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminUser::query();

        // ПОИСК
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(AdminUserStatusRequest $request, AdminUser $adminUser)
    {
        $adminUser->update([
            'status' => $request->status,
        ]);

        return redirect()->back();
    }
}
