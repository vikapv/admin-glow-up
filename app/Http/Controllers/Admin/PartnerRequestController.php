<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class PartnerRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerRequest::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->latest()->paginate(12);

        $stats = [
            'total'    => PartnerRequest::count(),
            'pending'  => PartnerRequest::where('status', 'pending')->count(),
            'approved' => PartnerRequest::where('status', 'approved')->count(),
            'rejected' => PartnerRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.partners.index', compact('requests', 'stats'));
    }

    public function show(PartnerRequest $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    public function approve(PartnerRequest $partner)
    {
        $partner->update(['status' => 'approved']);

        Brand::updateOrCreate(
            ['partner_request_id' => $partner->id],
            [
                'name' => $partner->name,
                'logo' => $partner->logo,
            ]
        );

        return redirect()->route('admin.partners.index')
            ->with('success', 'Партнёр «' . $partner->name . '» принят и добавлен в бренды');
    }

    public function reject(PartnerRequest $partner)
    {
        $partner->update(['status' => 'rejected']);

        Brand::where('partner_request_id', $partner->id)->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Заявка «' . $partner->name . '» отклонена');
    }

    public function destroy(PartnerRequest $partner)
    {
        Brand::where('partner_request_id', $partner->id)->delete();
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Заявка удалена');
    }
}