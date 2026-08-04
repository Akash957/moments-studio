<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique()->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->text('schema_markup')->nullable();
            $table->text('head_scripts')->nullable();
            $table->text('body_scripts')->nullable();
            $table->timestamps();
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name');
            $table->string('subject');
            $table->longText('body');
            $table->json('variables')->nullable(); // available template variables
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('original_name');
            $table->string('path');
            $table->string('url');
            $table->string('thumbnail_url')->nullable();
            $table->string('webp_url')->nullable();
            $table->string('disk')->default('public');
            $table->string('folder')->nullable()->index();
            $table->string('mime_type');
            $table->string('extension');
            $table->bigInteger('size');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['folder', 'mime_type']);
        });

        Schema::create('instagram_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('post_id')->unique();
            $table->string('media_url');
            $table->string('thumbnail_url')->nullable();
            $table->enum('media_type', ['IMAGE', 'VIDEO', 'CAROUSEL_ALBUM'])->default('IMAGE');
            $table->text('caption')->nullable();
            $table->string('permalink');
            $table->integer('like_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->timestamp('posted_at')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week'); // monday, tuesday, ...
            $table->time('start_time');
            $table->time('end_time');
            $table->string('label')->nullable(); // "Morning", "Afternoon"
            $table->boolean('is_active')->default(true);
            $table->integer('max_bookings')->default(1);
            $table->timestamps();
        });

        Schema::create('blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('reason')->nullable();
            $table->boolean('is_full_day')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocked_dates');
        Schema::dropIfExists('time_slots');
        Schema::dropIfExists('instagram_feeds');
        Schema::dropIfExists('media');
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('seo_metas');
    }
};
