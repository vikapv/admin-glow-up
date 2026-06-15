<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerRequestController extends Controller
{
    private string $api = 'http://127.0.0.1:8001/api';

    public function index(Request $request)
    {
        $response = Http::get("{$this->api}/partners", [
            'search' => $request->search,
            'status' => $request->status,
        ]);

        $json = $response->json();

        $allPartners = collect($json['partners'] ?? [])
            ->map(fn($p) => (object)$p);

        $stats = $json['stats'] ?? [
            'total'    => 0,
            'pending'  => 0,
            'approved' => 0,
            'rejected' => 0,
        ];

        // Пагинация
        $perPage     = 12;
        $currentPage = (int)($request->page ?? 1);
        $paginated   = new LengthAwarePaginator(
            $allPartners->values()->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $allPartners->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.partners.index', [
            'requests' => $paginated,
            'stats'    => $stats,
        ]);
    }

    public function approve($id)
    {
        $response = Http::post("{$this->api}/partners/{$id}/approve");

        if ($response->successful()) {
            return redirect()->route('admin.partners.index')
                ->with('success', 'Партнёр принят');
        }

        return redirect()->back()->with('error', 'Ошибка при принятии');
    }

    public function reject($id)
    {
        $response = Http::post("{$this->api}/partners/{$id}/reject");

        if ($response->successful()) {
            return redirect()->route('admin.partners.index')
                ->with('success', 'Заявка отклонена');
        }

        return redirect()->back()->with('error', 'Ошибка при отклонении');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->api}/partners/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.partners.index')
                ->with('success', 'Заявка удалена');
        }

        return redirect()->back()->with('error', 'Ошибка при удалении');
    }

    public function show($id)
    {
        $response = Http::get("{$this->api}/partners/{$id}");
        $partner  = (object)($response->json() ?? []);

        return view('admin.partners.show', compact('partner'));
    }
}