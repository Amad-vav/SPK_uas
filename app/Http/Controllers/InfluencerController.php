<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Influencer;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    public function manage()
    {
        $campaign_id = session('campaign_id');
        $campaigns = Campaign::all();
        
        if (!$campaign_id) {
            return view('campaign.index', compact('campaigns'))->with('error', 'Silakan buat atau pilih kampanye terlebih dahulu');
        }

        $campaign = Campaign::findOrFail($campaign_id);
        $influencers = Influencer::where('campaign_id', $campaign_id)->get();

        return view('influencer.manage', compact('campaign', 'influencers', 'campaigns'));
    }

    public function store(Request $request)
    {
        $campaign_id = session('campaign_id');
        if (!$campaign_id) {
            return response()->json(['error' => 'Campaign tidak dipilih'], 400);
        }

        $validated = $request->validate([
            'influencers' => 'required|array',
            'influencers.*.username' => 'required|string|max:255',
            'influencers.*.tipe_influencer' => 'required|string|max:255',
            'influencers.*.nilai_c1' => 'required|numeric|min:0|max:100',
            'influencers.*.nilai_c2' => 'required|numeric|min:0',
            'influencers.*.nilai_c3' => 'required|numeric|min:1|max:5',
            'influencers.*.nilai_c4' => 'required|numeric|min:0',
            'influencers.*.nilai_c5' => 'required|numeric|min:1|max:5',
        ]);

        // Hapus influencer lama
        Influencer::where('campaign_id', $campaign_id)->delete();

        // Insert influencer baru
        foreach ($validated['influencers'] as $inf) {
            Influencer::create([
                'campaign_id' => $campaign_id,
                'username' => $inf['username'],
                'tipe_influencer' => $inf['tipe_influencer'],
                'nilai_c1' => $inf['nilai_c1'],
                'nilai_c2' => $inf['nilai_c2'],
                'nilai_c3' => $inf['nilai_c3'],
                'nilai_c4' => $inf['nilai_c4'],
                'nilai_c5' => $inf['nilai_c5'],
            ]);
        }

        return redirect()->route('spk.result')->with('success', 'Data influencer berhasil disimpan!');
    }

    public function edit($id)
    {
        $influencer = Influencer::findOrFail($id);
        return response()->json($influencer);
    }

    public function update(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'tipe_influencer' => 'required|string|max:255',
            'nilai_c1' => 'required|numeric|min:0|max:100',
            'nilai_c2' => 'required|numeric|min:0',
            'nilai_c3' => 'required|numeric|min:1|max:5',
            'nilai_c4' => 'required|numeric|min:0',
            'nilai_c5' => 'required|numeric|min:1|max:5',
        ]);

        $influencer->update($validated);

        return redirect()->route('spk.result')->with('success', 'Data influencer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()->route('spk.result')->with('success', 'Influencer berhasil dihapus!');
    }
}
