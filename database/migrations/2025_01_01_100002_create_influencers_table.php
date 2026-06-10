<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('username');
            $table->string('tipe_influencer');
            $table->decimal('nilai_c1', 8, 2)->nullable();
            $table->decimal('nilai_c2', 15, 0)->nullable();
            $table->decimal('nilai_c3', 3, 1)->nullable();
            $table->decimal('nilai_c4', 15, 0)->nullable();
            $table->decimal('nilai_c5', 3, 1)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
