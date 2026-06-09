<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

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
            'total'  => User::count(),
            'active' => User::where('status', 'active')->count(),
            'banned' => User::where('status', 'banned')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,banned',
        ]);

        $user->update(['status' => $request->status]);

        $action = $request->status === 'banned' ? 'забанен' : 'разбанен';

        return redirect()->back()
            ->with('success', 'Пользователь «' . $user->name . '» ' . $action);
    }
}