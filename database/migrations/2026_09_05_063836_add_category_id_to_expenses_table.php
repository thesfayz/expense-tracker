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
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // эта миграция упадет из-за внешнего ключа
        //
        // вот это сначала вызвать нужно 
        // dropConstrainedForeignId('category_id')
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
