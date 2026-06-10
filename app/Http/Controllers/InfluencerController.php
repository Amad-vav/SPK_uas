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
            'influencers.*.tipe_influencer' => 'required|string|in:Nano,Micro,Macro,Mega / Celebrity',
            'influencers.*.nilai_c1' => 'required|numeric|min:1|max:100',
            'influencers.*.nilai_c2' => 'required|numeric|min:0',
            'influencers.*.nilai_c3' => 'required|numeric|min:1|max:5',
            'influencers.*.nilai_c4' => 'required|numeric|min:0',
            'influencers.*.nilai_c5' => 'required|numeric|min:1|max:5',
        ]);

        // Custom validation logic for C2 (Followers) depending on tipe_influencer
        $customErrors = [];
        foreach ($validated['influencers'] as $index => $inf) {
            $tipe = $inf['tipe_influencer'];
            $followers = (int) $inf['nilai_c2'];
            $rowNum = $index + 1;

            if ($tipe === 'Nano') {
                if ($followers < 1 || $followers > 10000) {
                    $customErrors["influencers.{$index}.nilai_c2"] = "Jumlah followers untuk Tipe Nano harus antara 1 - 10.000 (Influencer #{$rowNum})";
                }
            } elseif ($tipe === 'Micro') {
                if ($followers < 10001 || $followers > 100000) {
                    $customErrors["influencers.{$index}.nilai_c2"] = "Jumlah followers untuk Tipe Micro harus antara 10.001 - 100.000 (Influencer #{$rowNum})";
                }
            } elseif ($tipe === 'Macro') {
                if ($followers < 100001 || $followers > 1000000) {
                    $customErrors["influencers.{$index}.nilai_c2"] = "Jumlah followers untuk Tipe Macro harus antara 100.001 - 1.000.000 (Influencer #{$rowNum})";
                }
            } elseif ($tipe === 'Mega / Celebrity') {
                if ($followers < 1000001) {
                    $customErrors["influencers.{$index}.nilai_c2"] = "Jumlah followers untuk Tipe Mega / Celebrity harus di atas 1.000.000 (Influencer #{$rowNum})";
                }
            }
        }

        if (!empty($customErrors)) {
            return redirect()->back()->withErrors($customErrors)->withInput();
        }

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
            'tipe_influencer' => 'required|string|in:Nano,Micro,Macro,Mega / Celebrity',
            'nilai_c1' => 'required|numeric|min:1|max:100',
            'nilai_c2' => 'required|numeric|min:0',
            'nilai_c3' => 'required|numeric|min:1|max:5',
            'nilai_c4' => 'required|numeric|min:0',
            'nilai_c5' => 'required|numeric|min:1|max:5',
        ]);

        $tipe = $validated['tipe_influencer'];
        $followers = (int) $validated['nilai_c2'];

        if ($tipe === 'Nano' && ($followers < 1 || $followers > 10000)) {
            return redirect()->back()->withErrors(['nilai_c2' => 'Jumlah followers untuk Tipe Nano harus antara 1 - 10.000'])->withInput();
        } elseif ($tipe === 'Micro' && ($followers < 10001 || $followers > 100000)) {
            return redirect()->back()->withErrors(['nilai_c2' => 'Jumlah followers untuk Tipe Micro harus antara 10.001 - 100.000'])->withInput();
        } elseif ($tipe === 'Macro' && ($followers < 100001 || $followers > 1000000)) {
            return redirect()->back()->withErrors(['nilai_c2' => 'Jumlah followers untuk Tipe Macro harus antara 100.001 - 1.000.000'])->withInput();
        } elseif ($tipe === 'Mega / Celebrity' && $followers < 1000001) {
            return redirect()->back()->withErrors(['nilai_c2' => 'Jumlah followers untuk Tipe Mega / Celebrity harus di atas 1.000.000'])->withInput();
        }

        $influencer->update($validated);

        return redirect()->route('spk.result.saw')->with('success', 'Data influencer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()->route('spk.result.saw')->with('success', 'Influencer berhasil dihapus!');
    }
}
