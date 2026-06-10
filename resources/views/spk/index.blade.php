@extends('layouts.app')

@section('title', 'Dashboard SPK')

@section('content')
<div class="page-header">
    <h1>📊 Dashboard SPK - Pemilihan Influencer UMKM</h1>
    <p>Selamat datang di Sistem Pendukung Keputusan Pemilihan Influencer Metode SAW</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card" style="text-align: center; padding: 30px;">
            <div style="font-size: 40px; margin-bottom: 15px;">📁</div>
            <h5>Total Campaign</h5>
            <h2 style="color: var(--primary-emerald); font-weight: bold;">{{ $campaigns->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="text-align: center; padding: 30px;">
            <div style="font-size: 40px; margin-bottom: 15px;">👥</div>
            <h5>Total Influencer</h5>
            <h2 style="color: var(--primary-emerald); font-weight: bold;">{{ $campaigns->sum(fn($c) => $c->influencers->count()) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="text-align: center; padding: 30px;">
            <div style="font-size: 40px; margin-bottom: 15px;">📈</div>
            <h5>Status Sistem</h5>
            <h2 style="color: #28a745; font-weight: bold;">✓ Aktif</h2>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">🚀 Mulai Analisis</div>
            <div class="card-body">
                <p>Pilih salah satu opsi untuk memulai:</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('campaign.create') }}" class="btn btn-primary">
                        ➕ Buat Campaign Baru
                    </a>
                    <a href="{{ route('campaign.index') }}" class="btn btn-outline-primary">
                        📁 Lihat Semua Campaign
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">ℹ️ Tentang Sistem</div>
            <div class="card-body" style="font-size: 14px;">
                <p><strong>Metode:</strong> Simple Additive Weighting (SAW)</p>
                <p><strong>Kriteria:</strong> 5 Kriteria Utama</p>
                <p><strong>Fitur:</strong> Input Dinamis, Normalisasi Otomatis, Ranking Real-time</p>
                <p style="margin-bottom: 0;"><strong>Aplikasi:</strong> Gratis & Tanpa Registrasi</p>
            </div>
        </div>
    </div>
</div>

@if($campaigns->isNotEmpty())
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">📋 Campaign Terakhir</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama UMKM</th>
                                <th>Tipe Usaha</th>
                                <th>Nama Proyek</th>
                                <th>Influencer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns->take(5) as $campaign)
                                <tr>
                                    <td><strong>{{ $campaign->nama_umkm }}</strong></td>
                                    <td>{{ $campaign->tipe_umkm }}</td>
                                    <td>{{ $campaign->nama_proyek }}</td>
                                    <td>
                                        <span class="badge" style="background-color: var(--primary-emerald);">
                                            {{ $campaign->influencers->count() }} data
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('campaign.select', $campaign->id) }}" class="btn btn-sm btn-primary">
                                            Pilih
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">📚 Panduan Singkat</div>
            <div class="card-body" style="font-size: 14px;">
                <ol style="margin-bottom: 0; padding-left: 20px;">
                    <li>Buat campaign baru atau pilih yang sudah ada</li>
                    <li>Masukkan data influencer (minimal 1 influencer)</li>
                    <li>Isi nilai kriteria untuk setiap influencer</li>
                    <li>Sistem akan menghitung ranking otomatis</li>
                    <li>Lihat hasil analisis dan rekomendasi terbaik</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">🎯 Kriteria Penilaian</div>
            <div class="card-body" style="font-size: 13px;">
                <p><strong>C1: Engagement Rate</strong> (Benefit) - Bobot 25%</p>
                <p><strong>C2: Jumlah Followers</strong> (Benefit) - Bobot 20%</p>
                <p><strong>C3: Kesesuaian Niche</strong> (Benefit) - Bobot 20%</p>
                <p><strong>C4: Biaya per Post</strong> (Cost) - Bobot 20%</p>
                <p style="margin-bottom: 0;"><strong>C5: Attitude & Profesionalisme</strong> (Benefit) - Bobot 15%</p>
            </div>
        </div>
    </div>
</div>
@endsection
