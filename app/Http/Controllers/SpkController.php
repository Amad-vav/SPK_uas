<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Criteria;
use App\Models\Influencer;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::all();
        return view('spk.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaign.create');
    }

    public function storeCampaign(Request $request)
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

    public function selectCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        session(['campaign_id' => $campaign->id]);
        return redirect()->route('influencer.manage');
    }

    public function result()
    {
        $campaign_id = session('campaign_id');
        if (!$campaign_id) {
            return redirect()->route('campaign.index')->with('error', 'Silakan pilih kampanye terlebih dahulu');
        }

        $campaign = Campaign::findOrFail($campaign_id);
        $criterias = Criteria::all();
        $influencers = Influencer::where('campaign_id', $campaign_id)->get();

        if ($influencers->isEmpty()) {
            return redirect()->route('influencer.manage')->with('error', 'Tambahkan minimal satu influencer');
        }

        // Hitung SAW
        $sawResults = $this->calculateSAW($criterias, $influencers);

        return view('spk.result', compact('campaign', 'criterias', 'influencers', 'sawResults'));
    }

    private function calculateSAW($criterias, $influencers)
    {
        $criteria_array = [];
        foreach ($criterias as $c) {
            $criteria_array[$c->kode] = [
                'atribut' => $c->atribut,
                'bobot' => $c->bobot,
            ];
        }

        // Buat array data nilai
        $data_nilai = [];
        foreach ($influencers as $inf) {
            $data_nilai[$inf->id] = [
                'username' => $inf->username,
                'C1' => $inf->nilai_c1,
                'C2' => $inf->nilai_c2,
                'C3' => $inf->nilai_c3,
                'C4' => $inf->nilai_c4,
                'C5' => $inf->nilai_c5,
            ];
        }

        // Step 1: Normalisasi Matriks
        $matriks_normalisasi = [];
        foreach (array_keys($data_nilai) as $inf_id) {
            $matriks_normalisasi[$inf_id] = [];
            
            foreach (['C1', 'C2', 'C3', 'C4', 'C5'] as $c) {
                if ($criteria_array[$c]['atribut'] === 'Benefit') {
                    // MAX dari criteria
                    $max = max(array_column($data_nilai, $c));
                    $matriks_normalisasi[$inf_id][$c] = $max != 0 ? $data_nilai[$inf_id][$c] / $max : 0;
                } else {
                    // MIN dari criteria
                    $min = min(array_column($data_nilai, $c));
                    $matriks_normalisasi[$inf_id][$c] = $min != 0 ? $min / $data_nilai[$inf_id][$c] : 0;
                }
            }
        }

        // Step 2: Hitung Preferensi (Perkalian dengan bobot)
        $preferensi = [];
        foreach (array_keys($matriks_normalisasi) as $inf_id) {
            $preferensi[$inf_id] = 0;
            foreach (['C1', 'C2', 'C3', 'C4', 'C5'] as $c) {
                $preferensi[$inf_id] += $matriks_normalisasi[$inf_id][$c] * $criteria_array[$c]['bobot'];
            }
        }

        // Step 3: Urutkan hasil (ranking)
        arsort($preferensi);

        return [
            'data_nilai' => $data_nilai,
            'matriks_normalisasi' => $matriks_normalisasi,
            'preferensi' => $preferensi,
        ];
    }
}
