@extends('layouts.app')

@section('title', 'Buat Kampanye Baru')

@section('extra-css')
<style>
    .campaign-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .input-group-text {
        border-radius: 10px;
        background-color: #f8fafc;
        border-color: #cbd5e1;
        padding-left: 14px;
        padding-right: 14px;
    }

    .input-group > .form-control, 
    .input-group > .form-select {
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }
    
    .input-group > .input-group-text:first-child {
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
    }

    .input-group > .form-control:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .input-group > .input-group-text:last-child {
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }

    .input-group > .form-control:not(:last-child) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    
    .guide-card {
        border-left: 4px solid var(--primary);
    }
    
    .guide-step {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .step-number {
        background-color: #f0fdf4;
        color: var(--primary-dark);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="page-header mb-4">
    <h1 class="fw-bold">➕ Buat Kampanye Baru</h1>
    <p class="text-muted">Masukkan informasi UMKM dan proyek yang akan dianalisis</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card campaign-card border-0 shadow-sm mb-4">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-white"><i class="bi bi-folder-plus me-2"></i>Form Tambah Kampanye</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('campaign.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_umkm" class="form-label fw-medium">Nama UMKM <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shop text-muted"></i></span>
                            <input type="text" class="form-control @error('nama_umkm') is-invalid @enderror" 
                                   id="nama_umkm" name="nama_umkm" placeholder="Contoh: Toko Fashion Online Elegance" 
                                   value="{{ old('nama_umkm') }}" required>
                        </div>
                        @error('nama_umkm')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tipe_umkm" class="form-label fw-medium">Tipe Usaha <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase-fill text-muted"></i></span>
                            <select class="form-select @error('tipe_umkm') is-invalid @enderror" 
                                    id="tipe_umkm" name="tipe_umkm" required>
                                <option value="" disabled selected>-- Pilih Tipe Usaha --</option>
                                <option value="Fashion & Pakaian" @if(old('tipe_umkm') === 'Fashion & Pakaian') selected @endif>Fashion & Pakaian</option>
                                <option value="Kuliner & Makanan" @if(old('tipe_umkm') === 'Kuliner & Makanan') selected @endif>Kuliner & Makanan</option>
                                <option value="Kecantikan & Kosmetik" @if(old('tipe_umkm') === 'Kecantikan & Kosmetik') selected @endif>Kecantikan & Kosmetik</option>
                                <option value="Elektronik & Gadget" @if(old('tipe_umkm') === 'Elektronik & Gadget') selected @endif>Elektronik & Gadget</option>
                                <option value="Furniture & Dekorasi" @if(old('tipe_umkm') === 'Furniture & Dekorasi') selected @endif>Furniture & Dekorasi</option>
                                <option value="Jasa & Layanan" @if(old('tipe_umkm') === 'Jasa & Layanan') selected @endif>Jasa & Layanan</option>
                                <option value="Lainnya" @if(old('tipe_umkm') === 'Lainnya') selected @endif>Lainnya</option>
                            </select>
                        </div>
                        @error('tipe_umkm')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_proyek" class="form-label fw-medium">Nama Proyek / Campaign <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-megaphone-fill text-muted"></i></span>
                            <input type="text" class="form-control @error('nama_proyek') is-invalid @enderror" 
                                   id="nama_proyek" name="nama_proyek" 
                                   placeholder="Contoh: Kampanye Koleksi Summer 2025" 
                                   value="{{ old('nama_proyek') }}" required>
                        </div>
                        @error('nama_proyek')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pt-2 border-top d-flex gap-2">
                        <a href="{{ route('campaign.index') }}" class="btn btn-secondary px-4 py-2" style="border-radius: 10px;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 10px;">
                            <i class="bi bi-check2-circle me-1"></i> Buat Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card campaign-card guide-card border-0 shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-white"><i class="bi bi-info-circle me-2"></i>Alur Proses</h5>
            </div>
            <div class="card-body p-3" style="font-size: 0.9rem;">
                <div class="guide-step">
                    <span class="step-number">1</span>
                    <div><strong>Buat Campaign:</strong> Isi profil UMKM dan kampanye proyek.</div>
                </div>
                <div class="guide-step">
                    <span class="step-number">2</span>
                    <div><strong>Input Influencer:</strong> Masukkan detail profil & nilai kriteria influencer.</div>
                </div>
                <div class="guide-step">
                    <span class="step-number">3</span>
                    <div><strong>Proses SAW:</strong> Sistem menghitung normalisasi & ranking.</div>
                </div>
                <div class="guide-step">
                    <span class="step-number">4</span>
                    <div><strong>Rekomendasi:</strong> Dapatkan rekomendasi influencer terbaik.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
