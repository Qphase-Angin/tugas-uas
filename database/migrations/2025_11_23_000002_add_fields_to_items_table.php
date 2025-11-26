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
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->after('name');
            $table->string('image', 191)->nullable()->after('price');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['price', 'image', 'category_id']);
        });
    }
};
