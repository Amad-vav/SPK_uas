@extends('layouts.app')

@section('title', 'Input Data Influencer')

@section('extra-css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body, *, .form-control, .form-select, button {
        font-family: 'Inter', sans-serif !important;
    }

    .form-wrapper {
        max-width: 1150px;
        margin: 0 auto;
    }

    .sticky-header {
        position: sticky;
        top: 0;
        background: rgba(248, 250, 252, 0.95);
        backdrop-filter: blur(12px);
        z-index: 1010;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 35px;
        margin-top: -35px;
        margin-left: -35px;
        margin-right: -35px;
        margin-bottom: 24px;
    }

    .sticky-footer {
        position: sticky;
        bottom: 0;
        background: rgba(248, 250, 252, 0.95);
        backdrop-filter: blur(12px);
        z-index: 1010;
        border-top: 1px solid #e2e8f0;
        padding: 15px 35px;
        margin-bottom: -35px;
        margin-left: -35px;
        margin-right: -35px;
        margin-top: 24px;
    }

    .influencer-block {
        margin-bottom: 24px;
        animation: fadeInUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 1px 2px rgba(0, 0, 0, 0.04) !important;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
    }

    .btn-delete-row {
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-delete-row:hover {
        background-color: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    .btn-add-row {
        background-color: #f8fafc;
        color: #6366F1;
        border: 2px dashed #cbd5e1;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s ease;
        width: 100%;
        text-align: center;
        display: block;
        text-decoration: none;
    }

    .btn-add-row:hover {
        background-color: #f5f3ff;
        border-color: #6366F1;
        color: #6366F1;
        transform: translateY(-1px);
    }

    /* Criterion box with left border */
    .criterion-box {
        background-color: #f8fafc;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .criterion-benefit {
        border-left: 4px solid #10B981 !important;
    }

    .criterion-cost {
        border-left: 4px solid #F59E0B !important;
    }

    .criterion-box:focus-within {
        background-color: #ffffff;
        border-color: #6366F1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .criterion-box .form-control, 
    .criterion-box .form-select {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 4px 0 !important;
        font-size: 0.9rem;
        height: auto;
    }

    .criterion-box .input-group-text {
        border: none !important;
        background: transparent !important;
        padding: 4px 6px 4px 0 !important;
        color: #94a3b8;
    }

    .criterion-box .input-group {
        border-bottom: 1.5px solid #cbd5e1;
        border-radius: 0;
        transition: border-bottom-color 0.2s ease;
    }

    .criterion-box:focus-within .input-group {
        border-bottom-color: #6366F1;
    }

    /* Star Rating styling */
    .star-icon {
        cursor: pointer;
        transition: transform 0.1s ease;
        margin-right: 2px;
        user-select: none;
    }
    .star-icon:hover {
        transform: scale(1.25);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .hover-bg-light {
        transition: background-color 0.15s ease;
    }
    .hover-bg-light:hover {
        background-color: #f1f5f9;
    }

    .collapse-icon {
        transition: transform 0.2s ease;
    }

    /* Standard inputs outside criterion boxes */
    .input-group:not(.criterion-box .input-group) .form-control,
    .input-group:not(.criterion-box .input-group) .form-select {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
        background-color: #f8fafc;
    }
    .input-group:not(.criterion-box .input-group) .form-control:focus,
    .input-group:not(.criterion-box .input-group) .form-select:focus {
        background-color: #ffffff;
        border-color: #6366F1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }
    .input-group:not(.criterion-box .input-group) .input-group-text {
        border-radius: 8px;
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #64748b;
        font-size: 0.9rem;
    }

    /* Input group rounding overrides */
    .input-group:not(.criterion-box .input-group) > .form-control, 
    .input-group:not(.criterion-box .input-group) > .form-select {
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    .input-group:not(.criterion-box .input-group) > .input-group-text:first-child {
        border-top-left-radius: 8px !important;
        border-bottom-left-radius: 8px !important;
    }

    /* Sticky Action Buttons */
    .btn-primary-action {
        background-color: #10B981;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-primary-action:hover {
        background-color: #059669;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .btn-secondary-action {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-secondary-action:hover {
        background-color: #e2e8f0;
        color: #334155;
    }
</style>
@endsection

@section('content')
<div class="form-wrapper">
    <!-- Sticky Header -->
    <div class="sticky-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1" style="color: #0F172A;"><i class="bi bi-people-fill text-indigo" style="color: #6366F1;"></i> Input Data Influencer</h4>
            @if(session('campaign_id'))
                <span class="text-muted" style="font-size: 0.85rem;">
                    Campaign Aktif: <strong style="color: #0F172A;">{{ $campaign->nama_proyek ?? 'Tidak Diketahui' }}</strong> 
                    <a href="{{ route('campaign.index') }}" class="ms-2 text-decoration-underline text-indigo" style="color: #6366F1; font-weight: 500;">Ubah</a>
                </span>
            @endif
        </div>
        <div>
            @if(!session('campaign_id'))
                <div class="badge bg-warning text-dark px-3 py-2">⚠️ Pilih Campaign Dulu</div>
            @endif
        </div>
    </div>

    @if(!session('campaign_id'))
        <div class="alert alert-info border-0 shadow-sm rounded-3">
            <strong>ℹ️ Info:</strong> Silakan pilih atau buat kampanye terlebih dahulu di halaman <a href="{{ route('campaign.index') }}" class="alert-link text-decoration-underline">Kampanye</a>.
        </div>
    @else
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 p-3" style="background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
                <div class="d-flex gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                    <div>
                        <h6 class="fw-bold text-danger mb-1" style="font-size: 0.85rem;">Terjadi kesalahan pengisian data:</h6>
                        <ul class="mb-0 ps-3 text-danger-emphasis" style="font-size: 0.8rem; line-height: 1.5;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Panduan Kriteria & Skala Penilaian -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 4px solid #6366F1 !important; overflow: hidden;">
            <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center cursor-pointer p-3" 
                 onclick="toggleGuideCollapse()" style="background-color: #f8fafc !important;">
                <span class="fw-bold text-dark" style="font-size: 0.9rem; color: #1e293b;">
                    <i class="bi bi-info-circle-fill text-indigo me-2" style="color: #6366F1;"></i> 💡 Panduan Skala & Kriteria Penilaian (SAW)
                </span>
                <i class="bi bi-chevron-down text-muted" id="guide-chevron-icon" style="transition: transform 0.2s ease;"></i>
            </div>
            <div id="guide-body" class="d-none border-top">
                <div class="card-body p-3 bg-white">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0 align-middle" style="border-color: #cbd5e1;">
                            <thead style="background-color: #f1f5f9; color: #0f172a; font-size: 0.8rem;">
                                <tr>
                                    <th style="width: 10%;" class="text-center py-2.5 fw-bold border-bottom">Kode</th>
                                    <th style="width: 20%;" class="py-2.5 fw-bold border-bottom">Kriteria</th>
                                    <th style="width: 15%;" class="text-center py-2.5 fw-bold border-bottom">Atribut & Bobot</th>
                                    <th class="py-2.5 fw-bold border-bottom">Pedoman Pengisian & Skala Penilaian</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.85rem;">
                                <!-- C1 -->
                                <tr>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge fw-bold px-2 py-1.5" style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; min-width: 38px;">C1</span>
                                    </td>
                                    <td class="py-2.5 border-bottom"><strong>Engagement Rate</strong></td>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge border rounded-pill px-2.5 py-1" style="background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important; font-size: 10px;">Benefit • 25%</span>
                                    </td>
                                    <td class="py-2.5 border-bottom">
                                        <div class="fw-semibold text-dark mb-1">Rentang: 1% s.d. 100%</div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #fee2e2; color: #991b1b; border-color: #fca5a5 !important;">1% - 30% : Rendah</span>
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #fef3c7; color: #92400e; border-color: #fcd34d !important;">31% - 70% : Sedang</span>
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important;">71% - 100% : Tinggi (Sangat Baik)</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- C2 -->
                                <tr>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge fw-bold px-2 py-1.5" style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; min-width: 38px;">C2</span>
                                    </td>
                                    <td class="py-2.5 border-bottom"><strong>Jumlah Followers</strong></td>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge border rounded-pill px-2.5 py-1" style="background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important; font-size: 10px;">Benefit • 20%</span>
                                    </td>
                                    <td class="py-2.5 border-bottom">
                                        <div class="fw-semibold text-dark mb-1">Batas sesuai tipe influencer yang dipilih:</div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #d1d5db !important;">Nano: 1 - 10k</span>
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #e0f2fe; color: #0369a1; border-color: #7dd3fc !important;">Micro: 10k - 100k</span>
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #eef2ff; color: #4338ca; border-color: #a5b4fc !important;">Macro: 100k - 1M</span>
                                            <span class="badge border px-2.5 py-1.5 fw-bold" style="font-size: 11px; background-color: #f5f3ff; color: #6d28d9; border-color: #c084fc !important;">Mega: &gt; 1M</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- C3 -->
                                <tr>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge fw-bold px-2 py-1.5" style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; min-width: 38px;">C3</span>
                                    </td>
                                    <td class="py-2.5 border-bottom"><strong>Kesesuaian Niche</strong></td>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge border rounded-pill px-2.5 py-1" style="background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important; font-size: 10px;">Benefit • 20%</span>
                                    </td>
                                    <td class="py-2.5 border-bottom">
                                        <div class="fw-semibold text-dark mb-1">Rating kecocokan konten (1 - 5 Bintang):</div>
                                        <div class="d-flex flex-wrap gap-1.5" style="gap: 5px;">
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★1</span> Sangat Kurang</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★2</span> Kurang</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★3</span> Cukup</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★4</span> Sesuai</span>
                                            <span class="badge border fw-extrabold px-2.5 py-1.5" style="font-size: 11px; background-color: #fef3c7; color: #92400e; border-color: #fcd34d !important;"><span style="color: #b45309;">★5</span> Sangat Sesuai</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- C4 -->
                                <tr>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge fw-bold px-2 py-1.5" style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; min-width: 38px;">C4</span>
                                    </td>
                                    <td class="py-2.5 border-bottom"><strong>Biaya per Post</strong></td>
                                    <td class="text-center py-2.5 border-bottom">
                                        <span class="badge border rounded-pill px-2.5 py-1" style="background-color: #fef3c7; color: #92400e; border-color: #fcd34d !important; font-size: 10px;">Cost • 20%</span>
                                    </td>
                                    <td class="py-2.5 border-bottom">
                                        <div class="p-2 border rounded" style="background-color: #fffbeb; border-color: #fcd34d !important; color: #78350f; font-size: 11px; max-width: 600px;">
                                            <div class="fw-bold"><i class="bi bi-info-circle-fill" style="color: #b45309;"></i> Diisi nominal rupiah (Rp)</div>
                                            <span style="color: #92400e;">Sifat <strong>Cost</strong>: Semakin hemat/murah biaya, nilai preferensi akhir SAW semakin tinggi.</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- C5 -->
                                <tr>
                                    <td class="text-center py-2.5">
                                        <span class="badge fw-bold px-2 py-1.5" style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; min-width: 38px;">C5</span>
                                    </td>
                                    <td class="py-2.5"><strong>Attitude & Profesionalisme</strong></td>
                                    <td class="text-center py-2.5">
                                        <span class="badge border rounded-pill px-2.5 py-1" style="background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important; font-size: 10px;">Benefit • 15%</span>
                                    </td>
                                    <td class="py-2.5">
                                        <div class="fw-semibold text-dark mb-1">Rating profesionalisme & komunikasi (1 - 5 Bintang):</div>
                                        <div class="d-flex flex-wrap gap-1.5" style="gap: 5px;">
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★1</span> Sangat Buruk</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★2</span> Buruk</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★3</span> Cukup</span>
                                            <span class="badge border fw-bold px-2 py-1.5" style="font-size: 11px; background-color: #f3f4f6; color: #1f2937; border-color: #cbd5e1 !important;"><span style="color: #b45309;">★4</span> Baik</span>
                                            <span class="badge border fw-extrabold px-2.5 py-1.5" style="font-size: 11px; background-color: #d1fae5; color: #065f46; border-color: #6ee7b7 !important;"><span style="color: #b45309;">★5</span> Sangat Baik</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form id="influencerForm" action="{{ route('influencer.store') }}" method="POST">
            @csrf

            <div id="influencer-container">
                @php
                    $oldInfluencers = old('influencers');
                    $displayInfluencers = [];

                    if (is_array($oldInfluencers)) {
                        foreach ($oldInfluencers as $idx => $oldInf) {
                            $displayInfluencers[] = (object)[
                                'username' => $oldInf['username'] ?? '',
                                'tipe_influencer' => $oldInf['tipe_influencer'] ?? '',
                                'nilai_c1' => $oldInf['nilai_c1'] ?? '',
                                'nilai_c2' => $oldInf['nilai_c2'] ?? '',
                                'nilai_c3' => $oldInf['nilai_c3'] ?? 3,
                                'nilai_c4' => $oldInf['nilai_c4'] ?? '',
                                'nilai_c5' => $oldInf['nilai_c5'] ?? 3,
                            ];
                        }
                    } else {
                        foreach ($influencers as $influencer) {
                            $displayInfluencers[] = $influencer;
                        }
                    }
                @endphp

                @forelse($displayInfluencers as $index => $influencer)
                    <div class="influencer-block" data-row-id="{{ $index }}">
                        <!-- Accordion Header -->
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-3 hover-bg-light cursor-pointer"
                             onclick="toggleCollapse(this, '{{ $index }}')">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-chevron-down text-muted collapse-icon" id="icon-{{ $index }}"></i>
                                <div class="avatar-initial rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                                     id="avatar-{{ $index }}" style="width: 32px; height: 32px; font-size: 0.9rem; text-transform: uppercase; background-color: #eef2ff; color: #6366F1; border: 1px solid #c7d2fe;">
                                     {{ $influencer->username ? strtoupper(substr($influencer->username, 0, 1)) : '?' }}
                                </div>
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Influencer #{{ $index + 1 }}</h6>
                            </div>
                            <button type="button" class="btn-delete-row d-flex align-items-center gap-1" onclick="event.stopPropagation(); removeRow(this)">
                                <i class="bi bi-trash3-fill"></i> Hapus
                            </button>
                        </div>

                        <div class="row g-3" id="body-{{ $index }}">
                            <!-- Left Column: Informasi Profil -->
                            <div class="col-lg-4 col-md-5">
                                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                                        <i class="bi bi-info-circle-fill me-1"></i> Informasi Profil
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-at text-muted"></i></span>
                                            <input type="text" name="influencers[{{ $index }}][username]" 
                                                   class="form-control" placeholder="username" 
                                                   value="{{ $influencer->username }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Tipe Influencer <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-tag-fill text-muted"></i></span>
                                            <select name="influencers[{{ $index }}][tipe_influencer]" class="form-select" required>
                                                <option value="" disabled>Pilih tipe...</option>
                                                <option value="Nano" {{ $influencer->tipe_influencer == 'Nano' ? 'selected' : '' }}>Nano (Di bawah 10k)</option>
                                                <option value="Micro" {{ $influencer->tipe_influencer == 'Micro' ? 'selected' : '' }}>Micro (10k - 100k)</option>
                                                <option value="Macro" {{ $influencer->tipe_influencer == 'Macro' ? 'selected' : '' }}>Macro (100k - 1M)</option>
                                                <option value="Mega / Celebrity" {{ $influencer->tipe_influencer == 'Mega / Celebrity' ? 'selected' : '' }}>Mega / Celebrity (Di atas 1M)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Kriteria Penilaian -->
                            <div class="col-lg-8 col-md-7">
                                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                                        <i class="bi bi-sliders me-1"></i> Kriteria Penilaian (Metode SAW)
                                    </h6>

                                    <div class="row g-2">
                                        <!-- C1 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C1: Engagement Rate</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 25%</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="number" name="influencers[{{ $index }}][nilai_c1]" 
                                                           class="form-control" step="0.01" min="1" max="100" 
                                                           placeholder="1 - 100" value="{{ $influencer->nilai_c1 }}" required>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C2 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C2: Jumlah Followers</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="number" name="influencers[{{ $index }}][nilai_c2]" 
                                                           class="form-control" min="0" 
                                                           placeholder="Jumlah" value="{{ $influencer->nilai_c2 }}" required>
                                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C3 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C3: Kesesuaian Niche</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                                </div>
                                                <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c3-{{ $index }}">
                                                    <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                                        @for($star = 1; $star <= 5; $star++)
                                                            <i class="bi bi-star{{ $influencer->nilai_c3 >= $star ? '-fill' : '' }} star-icon" data-value="{{ $star }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">{{ $influencer->nilai_c3 }}</span>
                                                    <input type="hidden" name="influencers[{{ $index }}][nilai_c3]" id="input-c3-{{ $index }}" value="{{ $influencer->nilai_c3 }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C4 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-cost">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C4: Biaya per Post</label>
                                                    <span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Cost • 20%</span>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="padding-right: 0px;">Rp</span>
                                                    <input type="number" name="influencers[{{ $index }}][nilai_c4]" 
                                                           class="form-control" min="0" 
                                                           placeholder="Biaya" value="{{ $influencer->nilai_c4 }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C5 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C5: Attitude & Prof.</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 15%</span>
                                                </div>
                                                <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c5-{{ $index }}">
                                                    <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                                        @for($star = 1; $star <= 5; $star++)
                                                            <i class="bi bi-star{{ $influencer->nilai_c5 >= $star ? '-fill' : '' }} star-icon" data-value="{{ $star }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">{{ $influencer->nilai_c5 }}</span>
                                                    <input type="hidden" name="influencers[{{ $index }}][nilai_c5]" id="input-c5-{{ $index }}" value="{{ $influencer->nilai_c5 }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 6th helper info card -->
                                        <div class="col-md-6">
                                            <div class="criterion-box d-flex align-items-center gap-2" style="border-left: 4px solid #6366F1 !important; background-color: #f5f3ff;">
                                                <i class="bi bi-info-circle-fill" style="font-size: 1rem; color: #6366F1;"></i>
                                                <div style="line-height: 1.15;">
                                                    <span class="d-block fw-semibold text-dark" style="font-size: 9px;">Normalisasi SAW</span>
                                                    <span class="text-muted" style="font-size: 8px;">Peringkat otomatis real-time.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="influencer-block" data-row-id="0">
                        <!-- Accordion Header -->
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-3 hover-bg-light cursor-pointer"
                             onclick="toggleCollapse(this, '0')">
                            <div class="d-flex align-items-center gap-2">
                               <i class="bi bi-chevron-down text-muted collapse-icon" id="icon-0"></i>
                                <div class="avatar-initial rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                                     id="avatar-0" style="width: 32px; height: 32px; font-size: 0.9rem; text-transform: uppercase; background-color: #eef2ff; color: #6366F1; border: 1px solid #c7d2fe;">
                                     ?
                                </div>
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Influencer #1</h6>
                            </div>
                            <button type="button" class="btn-delete-row d-flex align-items-center gap-1" onclick="event.stopPropagation(); removeRow(this)">
                                <i class="bi bi-trash3-fill"></i> Hapus
                            </button>
                        </div>

                        <div class="row g-3" id="body-0">
                            <!-- Left Column: Informasi Profil -->
                            <div class="col-lg-4 col-md-5">
                                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                                        <i class="bi bi-info-circle-fill me-1"></i> Informasi Profil
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-at text-muted"></i></span>
                                            <input type="text" name="influencers[0][username]" 
                                                   class="form-control" placeholder="username" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Tipe Influencer <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-tag-fill text-muted"></i></span>
                                            <select name="influencers[0][tipe_influencer]" class="form-select" required>
                                                <option value="" disabled selected>Pilih tipe...</option>
                                                <option value="Nano">Nano (Di bawah 10k)</option>
                                                <option value="Micro">Micro (10k - 100k)</option>
                                                <option value="Macro">Macro (100k - 1M)</option>
                                                <option value="Mega / Celebrity">Mega / Celebrity (Di atas 1M)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Kriteria Penilaian -->
                            <div class="col-lg-8 col-md-7">
                                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                                    <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                                        <i class="bi bi-sliders me-1"></i> Kriteria Penilaian (Metode SAW)
                                    </h6>

                                    <div class="row g-2">
                                        <!-- C1 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C1: Engagement Rate</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 25%</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="number" name="influencers[0][nilai_c1]" 
                                                           class="form-control" step="0.01" min="1" max="100" 
                                                           placeholder="1 - 100" required>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C2 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C2: Jumlah Followers</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="number" name="influencers[0][nilai_c2]" 
                                                           class="form-control" min="0" 
                                                           placeholder="Jumlah" required>
                                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C3 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C3: Kesesuaian Niche</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                                </div>
                                                <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c3-0">
                                                    <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                                        <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                                        <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                                        <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                                        <i class="bi bi-star star-icon" data-value="4"></i>
                                                        <i class="bi bi-star star-icon" data-value="5"></i>
                                                    </div>
                                                    <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">3</span>
                                                    <input type="hidden" name="influencers[0][nilai_c3]" id="input-c3-0" value="3" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C4 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-cost">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C4: Biaya per Post</label>
                                                    <span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Cost • 20%</span>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="padding-right: 0px;">Rp</span>
                                                    <input type="number" name="influencers[0][nilai_c4]" 
                                                           class="form-control" min="0" 
                                                           placeholder="Biaya" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- C5 -->
                                        <div class="col-md-6">
                                            <div class="criterion-box criterion-benefit">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C5: Attitude & Prof.</label>
                                                    <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 15%</span>
                                                </div>
                                                <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c5-0">
                                                    <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                                        <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                                        <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                                        <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                                        <i class="bi bi-star star-icon" data-value="4"></i>
                                                        <i class="bi bi-star star-icon" data-value="5"></i>
                                                    </div>
                                                    <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">3</span>
                                                    <input type="hidden" name="influencers[0][nilai_c5]" id="input-c5-0" value="3" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 6th helper info card -->
                                        <div class="col-md-6">
                                            <div class="criterion-box d-flex align-items-center gap-2" style="border-left: 4px solid #6366F1 !important; background-color: #f5f3ff;">
                                                <i class="bi bi-info-circle-fill" style="font-size: 1rem; color: #6366F1;"></i>
                                                <div style="line-height: 1.15;">
                                                    <span class="d-block fw-semibold text-dark" style="font-size: 9px;">Normalisasi SAW</span>
                                                    <span class="text-muted" style="font-size: 8px;">Peringkat otomatis real-time.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-3 mb-2">
                <button type="button" class="btn btn-add-row" onclick="addNewRow()">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Baris Influencer Baru
                </button>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('campaign.index') }}" class="btn-secondary-action">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-primary-action">
                    <i class="bi bi-check2-circle"></i> Simpan & Lanjut ke Analisis
                </button>
            </div>
        </form>
    @endif
</div>

<script>
let rowCount = {{ max(1, count($displayInfluencers ?? $influencers)) }};

// Function to toggle rating scale guide collapse
function toggleGuideCollapse() {
    const body = document.getElementById('guide-body');
    const icon = document.getElementById('guide-chevron-icon');
    const isCollapsed = body.classList.contains('d-none');
    
    if (isCollapsed) {
        body.classList.remove('d-none');
        if (icon) icon.style.transform = 'rotate(180deg)';
    } else {
        body.classList.add('d-none');
        if (icon) icon.style.transform = 'rotate(0deg)';
    }
}

// Function to update followers (C2) range validation dynamically
function updateFollowersRange(tipeSelect) {
    const row = tipeSelect.closest('.influencer-block');
    if (!row) return;
    
    const c2Input = row.querySelector('input[name*="[nilai_c2]"]');
    if (!c2Input) return;
    
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
        c2Input.placeholder = "Jumlah";
    }
}

// Event delegation for tipe_influencer change
document.getElementById('influencer-container').addEventListener('change', function(e) {
    if (e.target.name && e.target.name.includes('[tipe_influencer]')) {
        updateFollowersRange(e.target);
    }
});

// Run for all existing rows on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[name*="[tipe_influencer]"]').forEach(select => {
        updateFollowersRange(select);
    });
});

// Star rating delegation
document.getElementById('influencer-container').addEventListener('click', function(e) {
    const starIcon = e.target.closest('.star-icon');
    if (starIcon) {
        const value = parseInt(starIcon.getAttribute('data-value'));
        const container = starIcon.closest('.star-rating-container');
        const targetInputId = container.getAttribute('data-target-input');
        const targetInput = document.getElementById(targetInputId);
        
        if (targetInput) {
            targetInput.value = value;
            
            // Update star icons visually
            const stars = container.querySelectorAll('.star-icon');
            stars.forEach((star, index) => {
                if (index < value) {
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                } else {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                }
            });
            
            // Update text label based on which input it is
            const labelSpan = container.querySelector('.star-label');
            labelSpan.textContent = value;
        }
    }
});

// Real-time avatar initial letter generator
document.getElementById('influencer-container').addEventListener('input', function(e) {
    if (e.target.name && e.target.name.includes('[username]')) {
        const row = e.target.closest('.influencer-block');
        const rowId = row.getAttribute('data-row-id');
        const avatar = document.getElementById(`avatar-${rowId}`);
        if (avatar) {
            const firstChar = e.target.value.trim().charAt(0);
            avatar.textContent = firstChar ? firstChar.toUpperCase() : '?';
        }
    }
});

function toggleCollapse(header, rowId) {
    const body = document.getElementById(`body-${rowId}`);
    const icon = document.getElementById(`icon-${rowId}`);
    const isCollapsed = body.classList.contains('d-none');
    
    if (isCollapsed) {
        body.classList.remove('d-none');
        if (icon) icon.style.transform = 'rotate(0deg)';
    } else {
        body.classList.add('d-none');
        if (icon) icon.style.transform = 'rotate(-90deg)';
    }
}

function addNewRow() {
    const container = document.getElementById('influencer-container');
    const newRow = `
        <div class="influencer-block" data-row-id="${rowCount}">
            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-3 hover-bg-light cursor-pointer"
                 onclick="toggleCollapse(this, '${rowCount}')">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chevron-down text-muted collapse-icon" id="icon-${rowCount}"></i>
                    <div class="avatar-initial rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                         id="avatar-${rowCount}" style="width: 32px; height: 32px; font-size: 0.9rem; text-transform: uppercase; background-color: #eef2ff; color: #6366F1; border: 1px solid #c7d2fe;">
                         ?
                    </div>
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Influencer #${rowCount + 1}</h6>
                </div>
                <button type="button" class="btn-delete-row d-flex align-items-center gap-1" onclick="event.stopPropagation(); removeRow(this)">
                    <i class="bi bi-trash3-fill"></i> Hapus
                </button>
            </div>

            <div class="row g-3" id="body-${rowCount}">
                <!-- Left Column: Informasi Profil -->
                <div class="col-lg-4 col-md-5">
                    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                        <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                            <i class="bi bi-info-circle-fill me-1"></i> Informasi Profil
                        </h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-at text-muted"></i></span>
                                <input type="text" name="influencers[${rowCount}][username]" 
                                       class="form-control" placeholder="username" required>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.8rem;">Tipe Influencer <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag-fill text-muted"></i></span>
                                <select name="influencers[${rowCount}][tipe_influencer]" class="form-select" required>
                                    <option value="" disabled selected>Pilih tipe...</option>
                                    <option value="Nano">Nano (Di bawah 10k)</option>
                                    <option value="Micro">Micro (10k - 100k)</option>
                                    <option value="Macro">Macro (100k - 1M)</option>
                                    <option value="Mega / Celebrity">Mega / Celebrity (Di atas 1M)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Kriteria Penilaian -->
                <div class="col-lg-8 col-md-7">
                    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                        <h6 class="fw-bold text-secondary mb-3 pb-2 border-bottom" style="letter-spacing: 0.05em; font-size: 0.75rem; text-transform: uppercase;">
                            <i class="bi bi-sliders me-1"></i> Kriteria Penilaian (Metode SAW)
                        </h6>

                        <div class="row g-2">
                            <!-- C1 -->
                            <div class="col-md-6">
                                <div class="criterion-box criterion-benefit">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C1: Engagement Rate</label>
                                        <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 25%</span>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" name="influencers[${rowCount}][nilai_c1]" 
                                               class="form-control" step="0.01" min="1" max="100" 
                                               placeholder="1 - 100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- C2 -->
                            <div class="col-md-6">
                                <div class="criterion-box criterion-benefit">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C2: Jumlah Followers</label>
                                        <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" name="influencers[${rowCount}][nilai_c2]" 
                                               class="form-control" min="0" 
                                               placeholder="Jumlah" required>
                                        <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- C3 -->
                            <div class="col-md-6">
                                <div class="criterion-box criterion-benefit">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C3: Kesesuaian Niche</label>
                                        <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 20%</span>
                                    </div>
                                    <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c3-${rowCount}">
                                        <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                            <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                            <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                            <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                            <i class="bi bi-star star-icon" data-value="4"></i>
                                            <i class="bi bi-star star-icon" data-value="5"></i>
                                        </div>
                                        <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">3</span>
                                        <input type="hidden" name="influencers[${rowCount}][nilai_c3]" id="input-c3-${rowCount}" value="3" required>
                                    </div>
                                </div>
                            </div>

                            <!-- C4 -->
                            <div class="col-md-6">
                                <div class="criterion-box criterion-cost">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C4: Biaya per Post</label>
                                        <span class="badge text-warning-emphasis bg-warning-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Cost • 20%</span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text" style="padding-right: 0px;">Rp</span>
                                        <input type="number" name="influencers[${rowCount}][nilai_c4]" 
                                               class="form-control" min="0" 
                                               placeholder="Biaya" required>
                                    </div>
                                </div>
                            </div>

                            <!-- C5 -->
                            <div class="col-md-6">
                                <div class="criterion-box criterion-benefit">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.75rem;">C5: Attitude & Prof.</label>
                                        <span class="badge text-success-emphasis bg-success-subtle rounded-pill" style="font-size: 8px; padding: 2px 6px;">Benefit • 15%</span>
                                    </div>
                                    <div class="star-rating-container d-flex align-items-center gap-1 mt-1" data-target-input="input-c5-${rowCount}">
                                        <div class="stars-row d-flex text-warning fs-5 cursor-pointer">
                                            <i class="bi bi-star-fill star-icon" data-value="1"></i>
                                            <i class="bi bi-star-fill star-icon" data-value="2"></i>
                                            <i class="bi bi-star-fill star-icon" data-value="3"></i>
                                            <i class="bi bi-star star-icon" data-value="4"></i>
                                            <i class="bi bi-star star-icon" data-value="5"></i>
                                        </div>
                                        <span class="star-label text-muted ms-1" style="font-size: 10px; font-weight: 500;">3</span>
                                        <input type="hidden" name="influencers[${rowCount}][nilai_c5]" id="input-c5-${rowCount}" value="3" required>
                                    </div>
                                </div>
                            </div>

                            <!-- 6th helper info card -->
                            <div class="col-md-6">
                                <div class="criterion-box d-flex align-items-center gap-2" style="border-left: 4px solid #6366F1 !important; background-color: #f5f3ff;">
                                    <i class="bi bi-info-circle-fill" style="font-size: 1rem; color: #6366F1;"></i>
                                    <div style="line-height: 1.15;">
                                        <span class="d-block fw-semibold text-dark" style="font-size: 9px;">Normalisasi SAW</span>
                                        <span class="text-muted" style="font-size: 8px;">Peringkat otomatis real-time.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newRow);
    rowCount++;
}

function removeRow(button) {
    const row = button.closest('.influencer-block');
    const container = document.getElementById('influencer-container');
    
    if (container.children.length > 1) {
        row.remove();
        updateRowNumbers();
    } else {
        alert('Minimal harus ada 1 influencer!');
    }
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('.influencer-block');
    rows.forEach((row, index) => {
        row.querySelector('h6').textContent = `Influencer #${index + 1}`;
    });
}
</script>
@endsection
