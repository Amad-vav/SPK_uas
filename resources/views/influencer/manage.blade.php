@extends('layouts.app')

@section('title', 'Input Data Influencer')

@section('extra-css')
<style>
    .influencer-form-row {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
        border-left: 4px solid var(--primary-emerald);
    }

    .btn-add-row {
        margin-top: 20px;
    }

    .remove-row-btn {
        color: #dc3545;
        cursor: pointer;
        font-weight: bold;
    }

    .remove-row-btn:hover {
        color: #c82333;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>👥 Input Data Influencer</h1>
    @if(session('campaign_id'))
        <p>Campaign: <strong>{{ $campaign->nama_proyek ?? 'Tidak Diketahui' }}</strong> 
           <a href="{{ route('campaign.index') }}" class="ms-3 btn btn-sm btn-outline-secondary">Ubah Campaign</a></p>
    @else
        <p class="alert alert-warning" style="display: inline-block; padding: 10px 15px; border-radius: 6px;">
            ⚠️ Belum ada campaign dipilih
        </p>
    @endif
</div>

@if(!session('campaign_id'))
    <div class="alert alert-info">
        <strong>ℹ️ Info:</strong> Silakan pilih atau buat kampanye terlebih dahulu di halaman <a href="{{ route('campaign.index') }}" class="alert-link">Kampanye</a>.
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Form Input Influencer (Dinamis)</div>
                <div class="card-body">
                    <form id="influencerForm" action="{{ route('influencer.store') }}" method="POST">
                        @csrf

                        <div id="influencer-container">
                            @forelse($influencers as $index => $influencer)
                                <div class="influencer-form-row" data-row-id="{{ $index }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong style="color: var(--primary-emerald);">Influencer #{{ $index + 1 }}</strong>
                                        <span class="remove-row-btn" onclick="removeRow(this)">🗑️ Hapus</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                                <input type="text" name="influencers[{{ $index }}][username]" 
                                                       class="form-control" placeholder="@username_influencer" 
                                                       value="{{ $influencer->username }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Tipe Influencer <span class="text-danger">*</span></label>
                                                <input type="text" name="influencers[{{ $index }}][tipe_influencer]" 
                                                       class="form-control" placeholder="Micro / Macro / Celebrity" 
                                                       value="{{ $influencer->tipe_influencer }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C1: Engagement Rate (%) <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[{{ $index }}][nilai_c1]" 
                                                       class="form-control" step="0.01" min="0" max="100" 
                                                       placeholder="0-100" value="{{ $influencer->nilai_c1 }}" required>
                                                <small class="text-muted">Benefit (0-100%)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C2: Jumlah Followers <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[{{ $index }}][nilai_c2]" 
                                                       class="form-control" min="0" 
                                                       placeholder="Jumlah followers" value="{{ $influencer->nilai_c2 }}" required>
                                                <small class="text-muted">Benefit (Lebih banyak lebih baik)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C3: Kesesuaian Niche <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[{{ $index }}][nilai_c3]" 
                                                       class="form-control" step="0.1" min="1" max="5" 
                                                       placeholder="1-5" value="{{ $influencer->nilai_c3 }}" required>
                                                <small class="text-muted">Benefit (Skala 1-5)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">C4: Biaya per Post (Rp) <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[{{ $index }}][nilai_c4]" 
                                                       class="form-control" min="0" 
                                                       placeholder="Biaya dalam Rupiah" value="{{ $influencer->nilai_c4 }}" required>
                                                <small class="text-muted">Cost (Lebih rendah lebih baik)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">C5: Attitude & Profesionalisme <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[{{ $index }}][nilai_c5]" 
                                                       class="form-control" step="0.1" min="1" max="5" 
                                                       placeholder="1-5" value="{{ $influencer->nilai_c5 }}" required>
                                                <small class="text-muted">Benefit (Skala 1-5)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="influencer-form-row" data-row-id="0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong style="color: var(--primary-emerald);">Influencer #1</strong>
                                        <span class="remove-row-btn" onclick="removeRow(this)">🗑️ Hapus</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                                <input type="text" name="influencers[0][username]" 
                                                       class="form-control" placeholder="@username_influencer" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">Tipe Influencer <span class="text-danger">*</span></label>
                                                <input type="text" name="influencers[0][tipe_influencer]" 
                                                       class="form-control" placeholder="Micro / Macro / Celebrity" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C1: Engagement Rate (%) <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[0][nilai_c1]" 
                                                       class="form-control" step="0.01" min="0" max="100" 
                                                       placeholder="0-100" required>
                                                <small class="text-muted">Benefit (0-100%)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C2: Jumlah Followers <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[0][nilai_c2]" 
                                                       class="form-control" min="0" 
                                                       placeholder="Jumlah followers" required>
                                                <small class="text-muted">Benefit (Lebih banyak lebih baik)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label">C3: Kesesuaian Niche <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[0][nilai_c3]" 
                                                       class="form-control" step="0.1" min="1" max="5" 
                                                       placeholder="1-5" required>
                                                <small class="text-muted">Benefit (Skala 1-5)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">C4: Biaya per Post (Rp) <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[0][nilai_c4]" 
                                                       class="form-control" min="0" 
                                                       placeholder="Biaya dalam Rupiah" required>
                                                <small class="text-muted">Cost (Lebih rendah lebih baik)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label">C5: Attitude & Profesionalisme <span class="text-danger">*</span></label>
                                                <input type="number" name="influencers[0][nilai_c5]" 
                                                       class="form-control" step="0.1" min="1" max="5" 
                                                       placeholder="1-5" required>
                                                <small class="text-muted">Benefit (Skala 1-5)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-add-row" onclick="addNewRow()">
                            ➕ Tambah Baris Influencer
                        </button>

                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('campaign.index') }}" class="btn btn-secondary">← Kembali</a>
                            <button type="submit" class="btn btn-primary">✓ Simpan & Lanjut ke Analisis</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">📋 Panduan Kriteria</div>
                <div class="card-body" style="font-size: 13px;">
                    <p><strong>C1: Engagement Rate</strong><br>Persentase engagement influencer (0-100%)</p>
                    <p><strong>C2: Jumlah Followers</strong><br>Jumlah followers pada akun</p>
                    <p><strong>C3: Kesesuaian Niche</strong><br>Kesamaan niche (skala 1-5)</p>
                    <p><strong>C4: Biaya per Post</strong><br>Biaya posting (Rupiah)</p>
                    <p><strong>C5: Attitude</strong><br>Profesionalisme (skala 1-5)</p>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
let rowCount = @json($influencers->count() || 1);

function addNewRow() {
    const container = document.getElementById('influencer-container');
    const newRow = `
        <div class="influencer-form-row" data-row-id="${rowCount}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong style="color: var(--primary-emerald);">Influencer #${rowCount + 1}</strong>
                <span class="remove-row-btn" onclick="removeRow(this)">🗑️ Hapus</span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="influencers[${rowCount}][username]" 
                               class="form-control" placeholder="@username_influencer" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">Tipe Influencer <span class="text-danger">*</span></label>
                        <input type="text" name="influencers[${rowCount}][tipe_influencer]" 
                               class="form-control" placeholder="Micro / Macro / Celebrity" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">C1: Engagement Rate (%) <span class="text-danger">*</span></label>
                        <input type="number" name="influencers[${rowCount}][nilai_c1]" 
                               class="form-control" step="0.01" min="0" max="100" 
                               placeholder="0-100" required>
                        <small class="text-muted">Benefit (0-100%)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">C2: Jumlah Followers <span class="text-danger">*</span></label>
                        <input type="number" name="influencers[${rowCount}][nilai_c2]" 
                               class="form-control" min="0" 
                               placeholder="Jumlah followers" required>
                        <small class="text-muted">Benefit (Lebih banyak lebih baik)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">C3: Kesesuaian Niche <span class="text-danger">*</span></label>
                        <input type="number" name="influencers[${rowCount}][nilai_c3]" 
                               class="form-control" step="0.1" min="1" max="5" 
                               placeholder="1-5" required>
                        <small class="text-muted">Benefit (Skala 1-5)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">C4: Biaya per Post (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="influencers[${rowCount}][nilai_c4]" 
                               class="form-control" min="0" 
                               placeholder="Biaya dalam Rupiah" required>
                        <small class="text-muted">Cost (Lebih rendah lebih baik)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <label class="form-label">C5: Attitude & Profesionalisme <span class="text-danger">*</span></label>
                        <input type="number" name="influencers[${rowCount}][nilai_c5]" 
                               class="form-control" step="0.1" min="1" max="5" 
                               placeholder="1-5" required>
                        <small class="text-muted">Benefit (Skala 1-5)</small>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newRow);
    rowCount++;
}

function removeRow(button) {
    const row = button.closest('.influencer-form-row');
    const container = document.getElementById('influencer-container');
    
    if (container.children.length > 1) {
        row.remove();
        updateRowNumbers();
    } else {
        alert('Minimal harus ada 1 influencer!');
    }
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('.influencer-form-row');
    rows.forEach((row, index) => {
        row.querySelector('strong').textContent = `Influencer #${index + 1}`;
    });
}
</script>
@endsection
