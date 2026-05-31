<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $tickets = $query->latest()->paginate(15);

        $stats = [
            'total'       => SupportTicket::count(),
            'new'         => SupportTicket::where('status', 'new')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved'    => SupportTicket::where('status', 'resolved')->count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    public function show(SupportTicket $ticket)
    {
        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'admin_reply' => 'required|string',
            'status'      => 'required|in:new,in_progress,resolved',
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status'      => $request->status,
        ]);

        return redirect()->back()
            ->with('success', 'Ответ сохранён');
    }

    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.support.index')
            ->with('success', 'Обращение удалено');
    }
}