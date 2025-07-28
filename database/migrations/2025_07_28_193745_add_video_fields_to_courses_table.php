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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('image');
            $table->string('video_filename')->nullable()->after('video_file');
            $table->string('video_mime_type')->nullable()->after('video_filename');
            $table->bigInteger('video_size')->nullable()->after('video_mime_type');
            $table->string('video_duration')->nullable()->after('video_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_filename', 'video_mime_type', 'video_size', 'video_duration']);
        });
    }
};
