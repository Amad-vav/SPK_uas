<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'username',
        'tipe_influencer',
        'nilai_c1',
        'nilai_c2',
        'nilai_c3',
        'nilai_c4',
        'nilai_c5',
    ];

    protected $casts = [
        'nilai_c1' => 'float',
        'nilai_c2' => 'integer',
        'nilai_c3' => 'integer',
        'nilai_c4' => 'integer',
        'nilai_c5' => 'integer',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
