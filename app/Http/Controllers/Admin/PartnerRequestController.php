<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerRequest;
use App\Models\Brand;

class PartnerRequestController extends Controller
{
    public function index()
    {
        $requests = PartnerRequest::all();
        return view('admin.partners.index', compact('requests'));
    }

    public function show(PartnerRequest $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    public function approve(PartnerRequest $partner)
    {
        Brand::create([
            'name' => $partner->name,
            'logo' => $partner->logo
        ]);

        $partner->update([
            'status' => 'approved'
        ]);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Партнёр успешно принят');
    }

    public function reject(PartnerRequest $partner)
    {
        $partner->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('admin.partners.index')
            ->with('error', 'Партнёр отклонён');
    }

    public function destroy(PartnerRequest $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Партнёр удалён');
    }
}