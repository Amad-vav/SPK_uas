@extends('layouts.app')

@section('title', 'Hasil Perhitungan SAW')

@section('extra-css')
<style>
    .table-container {
        margin-bottom: 30px;
    }

    .table-title {
        font-weight: bold;
        color: var(--primary-emerald);
        margin-bottom: 15px;
        font-size: 16px;
    }

    .result-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-sm-icon {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 8px;
    }

    /* Academic Table Styles */
    .academic-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .academic-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        padding: 12px 16px;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .academic-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .academic-table tr:hover {
        background-color: #f8fafc;
    }

    .winner-row {
        background-color: #fffbeb !important;
        border-left: 4px solid var(--warm-ochre);
    }

    .badge-champion {
        background-color: #fef3c7;
        color: #d97706;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 8px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Form control styling for the edit modal */
    .form-control, .form-select {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .input-group-text {
        border-radius: 8px;
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }

    .input-group > .form-control, 
    .input-group > .form-select {
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    
    .input-group > .input-group-text:first-child {
        border-top-left-radius: 8px !important;
        border-bottom-left-radius: 8px !important;
    }

    .input-group > .form-control:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .input-group > .input-group-text:last-child {
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }

    .input-group > .form-control:not(:last-child) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('spk.result') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
            <i class="bi bi-chevron-left"></i> Kembali ke Metode
        </a>
        <h1 class="mb-0 fs-3">📊 Hasil Perhitungan SAW</h1>
    </div>
    <p class="text-muted mt-1">Campaign: <strong>{{ $campaign->nama_proyek }}</strong> | UMKM: <strong>{{ $campaign->nama_umkm }}</strong></p>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 p-3" style="background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
        <div class="d-flex gap-2">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
            <div>
                <h6 class="fw-bold text-danger mb-1" style="font-size: 0.85rem;">Terjadi kesalahan saat memperbarui data:</h6>
                <ul class="mb-0 ps-3 text-danger-emphasis" style="font-size: 0.8rem; line-height: 1.5;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<!-- SAW Results -->
<div id="sawResults">
    <!-- Tabel Matriks Keputusan Awal -->
    <div class="result-card">
        <div class="table-title">Tabel 1: Matriks Keputusan Awal</div>
        <div style="overflow-x: auto;">
            <table class="academic-table w-100">
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;">No</th>
                        <th style="vertical-align: middle;">Influencer</th>
                        <th style="text-align: center;">C1<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Engagement Rate</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 25%</span></th>
                        <th style="text-align: center;">C2<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Jumlah Followers</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span></th>
                        <th style="text-align: center;">C3<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Kesesuaian Niche</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span></th>
                        <th style="text-align: center;">C4<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Biaya per Post</span><br><span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Cost • 20%</span></th>
                        <th style="text-align: center;">C5<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Attitude & Prof.</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 15%</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sawResults['data_nilai'] as $inf_id => $nilai)
                        @php
                            $influencer = $influencers->find($inf_id);
                            $no = $loop->iteration;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $no }}</td>
                            <td><strong>{{ $nilai['username'] }}</strong> <span class="text-muted" style="font-size: 11px;">({{ $influencer->tipe_influencer ?? '' }})</span></td>
                            <td style="text-align: center;">{{ number_format($nilai['C1'], 2) }}%</td>
                            <td style="text-align: center;">{{ number_format($nilai['C2'], 0) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai['C3'], 1) }}</td>
                            <td style="text-align: center;">Rp {{ number_format($nilai['C4'], 0) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai['C5'], 1) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Tidak ada data influencer</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Matriks Normalisasi -->
    <div class="result-card">
        <div class="table-title">Tabel 2: Matriks Normalisasi</div>
        <div style="overflow-x: auto;">
            <table class="academic-table w-100">
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;">No</th>
                        <th style="vertical-align: middle;">Influencer</th>
                        <th style="text-align: center;">C1 (r<sub>i1</sub>)<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Engagement Rate</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 25%</span></th>
                        <th style="text-align: center;">C2 (r<sub>i2</sub>)<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Jumlah Followers</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span></th>
                        <th style="text-align: center;">C3 (r<sub>i3</sub>)<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Kesesuaian Niche</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span></th>
                        <th style="text-align: center;">C4 (r<sub>i4</sub>)<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Biaya per Post</span><br><span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Cost • 20%</span></th>
                        <th style="text-align: center;">C5 (r<sub>i5</sub>)<br><span style="font-size: 0.75rem; font-weight: 500; text-transform: none; color: #475569;">Attitude & Prof.</span><br><span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 15%</span></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dataValues = $sawResults['data_nilai'];
                        $normalisasi = $sawResults['matriks_normalisasi'];
                    @endphp
                    @forelse($normalisasi as $inf_id => $nilai_norm)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $dataValues[$inf_id]['username'] }}</td>
                            <td style="text-align: center;">{{ number_format($nilai_norm['C1'], 4) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai_norm['C2'], 4) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai_norm['C3'], 4) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai_norm['C4'], 4) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai_norm['C5'], 4) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 p-3" style="background-color: #f9f9f9; border-radius: 6px; font-size: 11pt; font-family: 'Times New Roman', Times, serif;">
            <p style="margin: 0;">Keterangan:<br>
            • Benefit: r<sub>ij</sub> = x<sub>ij</sub> / max(x<sub>ij</sub>)<br>
            • Cost: r<sub>ij</sub> = min(x<sub>ij</sub>) / x<sub>ij</sub></p>
        </div>
    </div>

    <!-- Tabel Hasil Akhir Ranking -->
    <div class="result-card">
        <div class="table-title">Tabel 3: Nilai Preferensi & Ranking Akhir</div>
        <div style="overflow-x: auto;">
            <table class="academic-table w-100">
                <thead>
                    <tr>
                        <th style="text-align: center;">Rank</th>
                        <th style="text-align: center;">Influencer</th>
                        <th style="text-align: center;">Nilai Preferensi (V)</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ranking = 1;
                        $preferensi = $sawResults['preferensi'];
                        $dataValues = $sawResults['data_nilai'];
                    @endphp

                    @forelse($preferensi as $inf_id => $pref_value)
                        @php
                            $username = $dataValues[$inf_id]['username'] ?? 'Unknown';
                            $isWinner = ($ranking === 1);
                        @endphp
                        <tr @if($isWinner) class="winner-row" @endif>
                            <td style="text-align: center;">
                                @if($isWinner)
                                    <strong style="color: var(--warm-ochre); font-size: 16px;">🥇 #1</strong>
                                @else
                                    {{ $ranking }}
                                @endif
                            </td>
                            <td>
                                @if($isWinner)
                                    <strong>{{ $username }}</strong>
                                    <span class="badge-champion">👑 Rekomendasi Utama</span>
                                @else
                                    {{ $username }}
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <strong>{{ number_format($pref_value, 6) }}</strong>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-info btn-sm-icon text-white" data-influencer-id="{{ $inf_id }}" onclick="editInfluencer(this)">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('influencer.destroy', $inf_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus influencer ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm-icon">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php $ranking++; @endphp
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada data preferensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 p-3" style="background-color: #f9f9f9; border-radius: 6px; font-size: 11pt; font-family: 'Times New Roman', Times, serif;">
            <p style="margin: 0;">Keterangan:<br>
            • V<sub>i</sub> = Σ(w<sub>j</sub> × r<sub>ij</sub>)<br>
            • w<sub>j</sub> = bobot kriteria (dari database)<br>
            • Influencer dengan V<sub>i</sub> terbesar adalah rekomendasi terbaik</p>
        </div>
    </div>

    <!-- Bobot Kriteria -->
    <div class="result-card">
        <div class="table-title">Tabel 4: Bobot Kriteria (Normalisasi Bobot)</div>
        <div style="overflow-x: auto;">
            <table class="academic-table w-100">
                <thead>
                    <tr>
                        <th style="text-align: center;">Kode</th>
                        <th style="text-align: center;">Nama Kriteria</th>
                        <th style="text-align: center;">Atribut</th>
                        <th style="text-align: center;">Bobot (w<sub>j</sub>)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($criterias as $c)
                        <tr>
                            <td style="text-align: center;"><strong>{{ $c->kode }}</strong></td>
                            <td style="text-align: center;">{{ $c->nama_kriteria }}</td>
                            <td style="text-align: center;">
                                @if($c->atribut === 'Benefit')
                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 0.75rem; padding: 4px 10px;">Benefit</span>
                                @else
                                    <span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 0.75rem; padding: 4px 10px;">Cost</span>
                                @endif
                            </td>
                            <td style="text-align: center;"><strong>{{ number_format($c->bobot, 2) }}</strong> ({{ $c->bobot * 100 }}%)</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada kriteria</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan dan Kesimpulan -->
    <div class="result-card">
        <div class="table-title">📋 Ringkasan Hasil Analisis</div>
        @php
            $topInfluencer = $influencers->find(array_key_first($sawResults['preferensi']));
            $topScore = reset($sawResults['preferensi']);
        @endphp
        <div style="padding: 15px; background-color: #f9f9f9; border-radius: 8px; border-left: 4px solid var(--warm-ochre);">
            <p style="margin: 0; line-height: 1.8;">
                <strong style="color: var(--primary-emerald);">Rekomendasi Influencer Terpilih:</strong><br>
                <span style="font-size: 16px; color: var(--warm-ochre);">👑 {{ $topInfluencer->username ?? 'Unknown' }}</span><br>
                <small style="color: #666;">Nilai Preferensi: <strong>{{ number_format($topScore, 6) }}</strong></small>
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('campaign.index') }}" class="btn btn-secondary">📁 Daftar Campaign</a>
        <a href="{{ route('influencer.manage') }}" class="btn btn-primary text-white">✏️ Edit Data Influencer</a>
    </div>
</div>

<!-- Modal Edit Influencer -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Influencer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at text-muted"></i></span>
                            <input type="text" class="form-control" name="username" id="editUsername" placeholder="username_influencer" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tipe Influencer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag-fill text-muted"></i></span>
                            <select name="tipe_influencer" id="editTipeInfluencer" class="form-select" required>
                                <option value="" disabled selected>Pilih tipe...</option>
                                <option value="Nano">Nano (Di bawah 10k Followers)</option>
                                <option value="Micro">Micro (10k - 100k Followers)</option>
                                <option value="Macro">Macro (100k - 1M Followers)</option>
                                <option value="Mega / Celebrity">Mega / Celebrity (Di atas 1M Followers)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-medium">C1: Engagement Rate (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="nilai_c1" id="editC1" step="0.01" min="1" max="100" placeholder="1 - 100" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-medium">C2: Jumlah Followers <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="nilai_c2" id="editC2" min="0" placeholder="Followers" required>
                                    <span class="input-group-text"><i class="bi bi-people-fill text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-medium">C3: Kesesuaian Niche <span class="text-danger">*</span></label>
                                <select name="nilai_c3" id="editC3" class="form-select" required>
                                    <option value="1">1 - Sangat Tidak Sesuai</option>
                                    <option value="2">2 - Tidak Sesuai</option>
                                    <option value="3">3 - Cukup Sesuai</option>
                                    <option value="4">4 - Sesuai</option>
                                    <option value="5">5 - Sangat Sesuai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-medium">C4: Biaya per Post <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="nilai_c4" id="editC4" min="0" placeholder="Biaya" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">C5: Attitude & Profesionalisme <span class="text-danger">*</span></label>
                        <select name="nilai_c5" id="editC5" class="form-select" required>
                            <option value="1">1 - Sangat Buruk</option>
                            <option value="2">2 - Buruk</option>
                            <option value="3">3 - Cukup Baik</option>
                            <option value="4">4 - Baik</option>
                            <option value="5">5 - Sangat Baik</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
// Function to update C2 range validation in Edit Modal dynamically
function updateEditFollowersRange() {
    const tipeSelect = document.getElementById('editTipeInfluencer');
    const c2Input = document.getElementById('editC2');
    if (!tipeSelect || !c2Input) return;
    
    const tipe = tipeSelect.value;
    if (tipe === 'Nano') {
        c2Input.min = 1;
        c2Input.max = 10000;
        c2Input.placeholder = "1 - 10.000";
    } else if (tipe === 'Micro') {
        c2Input.min = 10001;
        c2Input.max = 100000;
        c2Input.placeholder = "10.001 - 100.000";
    } else if (tipe === 'Macro') {
        c2Input.min = 100001;
        c2Input.max = 1000000;
        c2Input.placeholder = "100.001 - 1.000.000";
    } else if (tipe === 'Mega / Celebrity') {
        c2Input.min = 1000001;
        c2Input.removeAttribute('max');
        c2Input.placeholder = "> 1.000.000";
    } else {
        c2Input.min = 0;
        c2Input.removeAttribute('max');
        c2Input.placeholder = "Followers";
    }
}

// Event listener for editTipeInfluencer change
document.addEventListener('DOMContentLoaded', function() {
    const editTipe = document.getElementById('editTipeInfluencer');
    if (editTipe) {
        editTipe.addEventListener('change', updateEditFollowersRange);
    }
});

async function editInfluencer(button) {
    const influencerId = button.getAttribute('data-influencer-id');
    
    try {
        const response = await fetch(`/influencer/${influencerId}/edit`);
        const data = await response.json();
        
        // Populate form
        document.getElementById('editUsername').value = data.username;
        document.getElementById('editTipeInfluencer').value = data.tipe_influencer;
        document.getElementById('editC1').value = data.nilai_c1;
        document.getElementById('editC2').value = data.nilai_c2;
        document.getElementById('editC3').value = data.nilai_c3;
        document.getElementById('editC4').value = data.nilai_c4;
        document.getElementById('editC5').value = data.nilai_c5;
        
        // Set form action
        document.getElementById('editForm').action = `/influencer/${influencerId}`;
        
        // Update range validation dynamically
        updateEditFollowersRange();
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data influencer');
    }
}
</script>
@endsection
