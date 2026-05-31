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

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20);

        $stats = [
            'total'  => AdminUser::count(),
            'active' => AdminUser::where('status', 'active')->count(),
            'banned' => AdminUser::where('status', 'banned')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function updateStatus(AdminUserStatusRequest $request, AdminUser $adminUser)
    {
        $adminUser->update(['status' => $request->status]);

        $action = $request->status === 'banned' ? 'забанен' : 'разбанен';

        return redirect()->back()
            ->with('success', 'Пользователь «' . $adminUser->name . '» ' . $action);
    }
}