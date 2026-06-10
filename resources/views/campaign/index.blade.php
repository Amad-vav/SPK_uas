@extends('layouts.app')

@section('title', 'Daftar Kampanye')

@section('content')
<div class="page-header">
    <h1>📁 Daftar Kampanye</h1>
    <p>Pilih kampanye yang ada atau buat kampanye baru</p>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('campaign.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Buat Campaign Baru
        </a>
    </div>
</div>

@if($campaigns->isEmpty())
    <div class="alert alert-info">
        <strong>ℹ️ Info:</strong> Belum ada kampanye. Silakan <a href="{{ route('campaign.create') }}" class="alert-link">buat kampanye baru</a>.
    </div>
@else
    <div class="row">
        @foreach($campaigns as $campaign)
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--primary-emerald);">{{ $campaign->nama_umkm }}</h5>
                        <p class="card-text text-muted">
                            <strong>Tipe UMKM:</strong> {{ $campaign->tipe_umkm }}<br>
                            <strong>Proyek:</strong> {{ $campaign->nama_proyek }}
                        </p>
                        <small class="text-muted">Dibuat: {{ $campaign->created_at->format('d M Y') }}</small>
                        <div class="mt-3">
                            <a href="{{ route('campaign.select', $campaign->id) }}" class="btn btn-primary btn-sm w-100">
                                Pilih Kampanye
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
