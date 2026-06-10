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

    .result-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .table-title {
        font-weight: bold;
        color: var(--primary-emerald);
        margin-bottom: 15px;
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .method-selector {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header mb-4">
    <h1>📈 Hasil Analisis SPK</h1>
    <p class="text-muted mt-1">Campaign: <strong>{{ $campaign->nama_proyek }}</strong> | UMKM: <strong>{{ $campaign->nama_umkm }}</strong></p>
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
            <a href="{{ route('spk.result.saw') }}" class="btn btn-primary mt-2 text-white px-4 py-2" style="border-radius: 8px; font-weight: 500;">
                Lihat Hasil SAW
            </a>
        </div>

        <!-- AHP/WP Method (VIP) -->
        <div class="method-card vip" onclick="showVIPModal()">
            <div class="method-badge badge-vip">👑 VIP</div>
            <h3 style="opacity: 0.6;">Metode WP/AHP</h3>
            <p style="color: #999; margin: 10px 0;">Weighted Product / Analytic Hierarchy</p>
            <p style="font-size: 12px; color: #999;">Perhitungan perkalian bobot lanjutan</p>
            <div class="lock-icon">🔒</div>
            <button type="button" class="btn btn-warning mt-2 text-white px-4 py-2" disabled style="opacity: 0.6; border-radius: 8px;">
                Terkunci (VIP)
            </button>
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
@endsection

@section('extra-js')
<script>
function showVIPModal() {
    const modal = new bootstrap.Modal(document.getElementById('vipModal'));
    modal.show();
}
</script>
@endsection
