<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('price_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads')->cascadeOnDelete();
            $table->decimal('old_price', 12, 2)->nullable();
            $table->decimal('new_price', 12, 2);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('price_changes'); }
};
