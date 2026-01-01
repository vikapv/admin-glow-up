<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserStatusRequest;
use App\Models\AdminUser;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = AdminUser::all();
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
