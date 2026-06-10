<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_umkm',
        'tipe_umkm',
        'nama_proyek',
    ];

    public function influencers()
    {
        return $this->hasMany(Influencer::class);
    }
}
