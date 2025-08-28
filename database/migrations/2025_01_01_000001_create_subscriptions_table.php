<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads')->cascadeOnDelete();
            $table->string('email');
            $table->string('verify_token')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->unique(['ad_id','email']);
        });
    }
    public function down(): void { Schema::dropIfExists('subscriptions'); }
};
