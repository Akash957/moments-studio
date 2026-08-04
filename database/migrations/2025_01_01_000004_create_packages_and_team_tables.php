<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('INR');
            $table->string('price_label')->nullable(); // "Starting from", "Per Day"
            $table->string('badge')->nullable(); // "Most Popular", "Best Value"
            $table->string('badge_color')->default('#c9a96e');
            $table->integer('hours')->nullable();
            $table->integer('edited_photos')->nullable();
            $table->integer('photographers')->default(1);
            $table->boolean('includes_video')->default(false);
            $table->boolean('includes_drone')->default(false);
            $table->boolean('includes_album')->default(false);
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_popular')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('feature');
            $table->boolean('is_included')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_image')->nullable();
            $table->string('wedding_location')->nullable();
            $table->date('wedding_date')->nullable();
            $table->text('review');
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->string('source')->default('website'); // google, website, instagram
            $table->string('source_url')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_approved')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('organization');
            $table->integer('year');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('certificate_url')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->json('specializations')->nullable();
            $table->integer('experience_years')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('awards');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('package_features');
        Schema::dropIfExists('packages');
    }
};
