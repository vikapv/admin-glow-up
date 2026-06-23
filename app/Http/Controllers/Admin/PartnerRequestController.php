<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerRequest::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Если статус передан — фильтруем по нему.
        // Если НЕ передан — показываем ВСЕ заявки (а не только pending).
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $paginated = $query->latest()->paginate(12)->withQueryString();

        $stats = [
            'total'    => PartnerRequest::count(),
            'pending'  => PartnerRequest::where('status', 'pending')->count(),
            'approved' => PartnerRequest::where('status', 'approved')->count(),
            'rejected' => PartnerRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.partners.index', [
            'requests' => $paginated,
            'stats'    => $stats,
        ]);
    }

    public function show($id)
    {
        $partner = PartnerRequest::findOrFail($id);
        $brand   = Brand::where('partner_request_id', $partner->id)->first();

        return view('admin.partners.show', compact('partner', 'brand'));
    }

    public function approve($id)
    {
        $partner = PartnerRequest::findOrFail($id);

        DB::transaction(function () use ($partner) {
            $partner->status = 'approved';
            $partner->save();

            // Создаём бренд, если его ещё нет, иначе обновляем данные
            Brand::updateOrCreate(
                ['partner_request_id' => $partner->id],
                [
                    'name' => $partner->name,
                    'logo' => $partner->logo,
                ]
            );
        });

        return redirect()->route('admin.partners.show', $partner->id)
            ->with('success', 'Партнёр принят и добавлен в бренды');
    }

    public function reject($id)
    {
        $partner = PartnerRequest::findOrFail($id);

        DB::transaction(function () use ($partner) {
            $partner->status = 'rejected';
            $partner->save();

            // Если партнёр был ранее принят и стал брендом — убираем его из брендов
            Brand::where('partner_request_id', $partner->id)->delete();
        });

        return redirect()->route('admin.partners.show', $partner->id)
            ->with('success', 'Заявка отклонена');
    }

    public function destroy($id)
    {
        $partner = PartnerRequest::findOrFail($id);

        DB::transaction(function () use ($partner) {
            Brand::where('partner_request_id', $partner->id)->delete();
            $partner->delete();
        });

        return redirect()->route('admin.partners.index')
            ->with('success', 'Заявка удалена');
    }
}