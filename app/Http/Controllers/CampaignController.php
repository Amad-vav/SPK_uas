<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::all();
        return view('campaign.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaign.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'tipe_umkm' => 'required|string|max:255',
            'nama_proyek' => 'required|string|max:255',
        ]);

        $campaign = Campaign::create($validated);
        session(['campaign_id' => $campaign->id]);

        return redirect()->route('influencer.manage')->with('success', 'Kampanye berhasil dibuat!');
    }

    public function select($id)
    {
        $campaign = Campaign::findOrFail($id);
        session(['campaign_id' => $campaign->id]);
        return redirect()->route('influencer.manage');
    }
}
