@extends('layouts.app')

@section('title', 'Buat Kampanye Baru')

@section('content')
<div class="page-header">
    <h1>➕ Buat Kampanye Baru</h1>
    <p>Masukkan informasi UMKM dan proyek yang akan dianalisis</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Form Tambah Kampanye</div>
            <div class="card-body">
                <form action="{{ route('campaign.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_umkm" class="form-label">Nama UMKM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_umkm') is-invalid @enderror" 
                               id="nama_umkm" name="nama_umkm" placeholder="Contoh: Toko Fashion Online Elegance" 
                               value="{{ old('nama_umkm') }}" required>
                        @error('nama_umkm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipe_umkm" class="form-label">Tipe Usaha <span class="text-danger">*</span></label>
                        <select class="form-control @error('tipe_umkm') is-invalid @enderror" 
                                id="tipe_umkm" name="tipe_umkm" required>
                            <option value="">-- Pilih Tipe Usaha --</option>
                            <option value="Fashion & Pakaian" @if(old('tipe_umkm') === 'Fashion & Pakaian') selected @endif>Fashion & Pakaian</option>
                            <option value="Kuliner & Makanan" @if(old('tipe_umkm') === 'Kuliner & Makanan') selected @endif>Kuliner & Makanan</option>
                            <option value="Kecantikan & Kosmetik" @if(old('tipe_umkm') === 'Kecantikan & Kosmetik') selected @endif>Kecantikan & Kosmetik</option>
                            <option value="Elektronik & Gadget" @if(old('tipe_umkm') === 'Elektronik & Gadget') selected @endif>Elektronik & Gadget</option>
                            <option value="Furniture & Dekorasi" @if(old('tipe_umkm') === 'Furniture & Dekorasi') selected @endif>Furniture & Dekorasi</option>
                            <option value="Jasa & Layanan" @if(old('tipe_umkm') === 'Jasa & Layanan') selected @endif>Jasa & Layanan</option>
                            <option value="Lainnya" @if(old('tipe_umkm') === 'Lainnya') selected @endif>Lainnya</option>
                        </select>
                        @error('tipe_umkm')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_proyek" class="form-label">Nama Proyek / Campaign <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_proyek') is-invalid @enderror" 
                               id="nama_proyek" name="nama_proyek" 
                               placeholder="Contoh: Kampanye Koleksi Summer 2025" 
                               value="{{ old('nama_proyek') }}" required>
                        @error('nama_proyek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="{{ route('campaign.index') }}" class="btn btn-secondary">← Kembali</a>
                        <button type="submit" class="btn btn-primary">✓ Buat Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">ℹ️ Informasi</div>
            <div class="card-body" style="font-size: 14px;">
                <p><strong>Langkah 1:</strong> Isi informasi UMKM dan kampanye</p>
                <p><strong>Langkah 2:</strong> Tambahkan data influencer</p>
                <p><strong>Langkah 3:</strong> Jalankan analisis SAW</p>
                <p><strong>Langkah 4:</strong> Lihat hasil ranking influencer</p>
            </div>
        </div>
    </div>
</div>
@endsection
