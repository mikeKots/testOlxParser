<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->decimal('last_price', 12, 2)->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ads'); }
};
