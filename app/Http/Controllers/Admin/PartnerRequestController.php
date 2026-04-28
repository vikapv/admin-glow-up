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
        $partner->update(['status' => 'approved']);

        // создаём бренд только если его ещё нет
        Brand::firstOrCreate([
            'name' => $partner->name
        ], [
            'logo' => $partner->logo
        ]);

        return redirect()->route('admin.partners.index');
    }

    public function reject(PartnerRequest $partner)
    {
        $partner->update(['status' => 'rejected']);

        return redirect()->route('admin.partners.index');
    }

    public function destroy(PartnerRequest $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index');
    }
}