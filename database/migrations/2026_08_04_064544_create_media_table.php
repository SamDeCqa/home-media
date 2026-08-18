<?php

use App\Enums\DisksEnum;
use App\Enums\MediaProcessingStatus;
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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->string('path');
            $table->string('content_type');
            $table->text('description')->nullable();
            $table->string('disk')->default(DisksEnum::LOCAL->value);
            $table->string('processing_status')->default(MediaProcessingStatus::PENDING->value);
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_private')->default(true);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('byte_size');
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['name']);
            $table->fullText('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
