<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->text('long_url');
            $table->string('url_id', 20)->unique(); // This is the slug (e.g., 444)
            $table->string('uid')->unique(); // This is the auto-generated ULID
            $table->string('description')->nullable();
            $table->unsignedBigInteger('click_count')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('url_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
