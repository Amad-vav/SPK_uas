@extends('layouts.app')

@section('title', 'Hasil Analisis SPK')

@section('extra-css')
<style>
    .method-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .method-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .method-card.active {
        border-color: var(--primary-emerald);
        background-color: rgba(9, 121, 105, 0.05);
    }

    .method-card h3 {
        color: var(--primary-emerald);
        margin-bottom: 10px;
    }

    .method-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .badge-free {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-vip {
        background-color: var(--warm-ochre);
        color: white;
    }

    .method-card.vip {
        opacity: 0.7;
        pointer-events: none;
    }

    .lock-icon {
        font-size: 30px;
        margin: 10px 0;
    }

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
        padding: 5px 10px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .method-selector {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>📈 Hasil Analisis SPK</h1>
    <p>Campaign: <strong>{{ $campaign->nama_proyek }}</strong> | UMKM: <strong>{{ $campaign->nama_umkm }}</strong></p>
</div>

<!-- Method Selection Card -->
<div class="result-card">
    <div class="table-title">Pilih Metode Analisis</div>
    <div class="method-selector">
        <!-- SAW Method (Free) -->
        <div class="method-card active">
            <div class="method-badge badge-free">✓ GRATIS</div>
            <h3>Metode SAW</h3>
            <p style="color: #666; margin: 10px 0;">Simple Additive Weighting</p>
            <p style="font-size: 12px; color: #999;">Perhitungan bobot linear sederhana</p>
            <div class="lock-icon">🔓</div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="showSAWMethod()">
                Lihat Hasil SAW
            </button>
        </div>

        <!-- AHP/WP Method (VIP) -->
        <div class="method-card vip" onclick="showVIPModal()">
            <div class="method-badge badge-vip">👑 VIP</div>
            <h3 style="opacity: 0.6;">Metode WP/AHP</h3>
            <p style="color: #999; margin: 10px 0;">Weighted Product / Analytic Hierarchy</p>
            <p style="font-size: 12px; color: #999;">Perhitungan perkalian bobot lanjutan</p>
            <div class="lock-icon">🔒</div>
            <button type="button" class="btn btn-warning btn-sm mt-2" disabled style="opacity: 0.6;">
                Terkunci (VIP)
            </button>
        </div>
    </div>
</div>

<!-- SAW Results -->
<div id="sawResults" style="display: block;">
    <!-- Tabel Matriks Keputusan Awal -->
    <div class="result-card">
        <div class="table-title">Tabel 1: Matriks Keputusan Awal</div>
        <div style="overflow-x: auto;">
            <table class="academic-table w-100">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Influencer</th>
                        <th style="text-align: center;">C1<br>(Engagement %)</th>
                        <th style="text-align: center;">C2<br>(Followers)</th>
                        <th style="text-align: center;">C3<br>(Niche 1-5)</th>
                        <th style="text-align: center;">C4<br>(Biaya Rp)</th>
                        <th style="text-align: center;">C5<br>(Attitude 1-5)</th>
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
                            <td>{{ $nilai['username'] }}</td>
                            <td style="text-align: center;">{{ number_format($nilai['C1'], 2) }}%</td>
                            <td style="text-align: right;">{{ number_format($nilai['C2'], 0) }}</td>
                            <td style="text-align: center;">{{ number_format($nilai['C3'], 1) }}</td>
                            <td style="text-align: right;">Rp {{ number_format($nilai['C4'], 0) }}</td>
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
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Influencer</th>
                        <th style="text-align: center;">r11 (C1)</th>
                        <th style="text-align: center;">r12 (C2)</th>
                        <th style="text-align: center;">r13 (C3)</th>
                        <th style="text-align: center;">r14 (C4)</th>
                        <th style="text-align: center;">r15 (C5)</th>
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
                    @forelse($sawResults['preferensi'] as $rank => $inf_id_and_value)
                        @php
                            $inf_id = $inf_id_and_value;
                            if (is_numeric($inf_id_and_value)) {
                                // Ini adalah value dari arsort
                                // Kita perlu mencari kembali dari preferensi dengan key
                            }
                            $ranking = 0;
                        @endphp
                    @endforeach

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
                                    <button type="button" class="btn btn-info btn-sm-icon" data-influencer-id="{{ $inf_id }}" onclick="editInfluencer(this)">
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
                        <th style="text-align: center;">Kriteria</th>
                        <th style="text-align: center;">Nama Kriteria</th>
                        <th style="text-align: center;">Atribut</th>
                        <th style="text-align: center;">Bobot (w<sub>j</sub>)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($criterias as $c)
                        <tr>
                            <td style="text-align: center;"><strong>{{ $c->kode }}</strong></td>
                            <td>{{ $c->nama_kriteria }}</td>
                            <td style="text-align: center;">
                                @if($c->atribut === 'Benefit')
                                    <span style="color: #28a745; font-weight: bold;">↑ Benefit</span>
                                @else
                                    <span style="color: #dc3545; font-weight: bold;">↓ Cost</span>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ number_format($c->bobot, 2) }}</td>
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
        <a href="{{ route('influencer.manage') }}" class="btn btn-primary">✏️ Edit Data Influencer</a>
    </div>
</div>

<!-- Modal Edit Influencer -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Influencer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="editUsername" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Influencer</label>
                        <input type="text" class="form-control" name="tipe_influencer" id="editTipeInfluencer" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">C1: Engagement Rate (%)</label>
                                <input type="number" class="form-control" name="nilai_c1" id="editC1" step="0.01" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">C2: Followers</label>
                                <input type="number" class="form-control" name="nilai_c2" id="editC2" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">C3: Kesesuaian Niche (1-5)</label>
                                <input type="number" class="form-control" name="nilai_c3" id="editC3" step="0.1" min="1" max="5" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">C4: Biaya (Rp)</label>
                                <input type="number" class="form-control" name="nilai_c4" id="editC4" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">C5: Attitude (1-5)</label>
                        <input type="number" class="form-control" name="nilai_c5" id="editC5" step="0.1" min="1" max="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal VIP -->
<div class="modal fade" id="vipModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">👑 Fitur VIP Terkunci</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div style="font-size: 48px; margin: 20px 0;">🔒</div>
                <p style="font-size: 16px; margin-bottom: 15px;">
                    <strong>Fitur ini khusus untuk akun Premium/VIP</strong>
                </p>
                <p style="color: #666; margin-bottom: 20px;">
                    Metode WP/AHP (Weighted Product / Analytic Hierarchy Process) adalah fitur lanjutan yang tersedia untuk akun premium. Silakan hubungi admin untuk mengaktifkan akun VIP Anda.
                </p>
                <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 14px; color: #999;">
                        <strong>Fitur SAW</strong> sudah tersedia gratis dan dapat digunakan untuk analisis dasar.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showSAWMethod() {
    document.getElementById('sawResults').style.display = 'block';
}

function showVIPModal() {
    const modal = new bootstrap.Modal(document.getElementById('vipModal'));
    modal.show();
}

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
