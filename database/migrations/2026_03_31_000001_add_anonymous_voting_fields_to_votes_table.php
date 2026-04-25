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
        Schema::table('votes', function (Blueprint $table) {
            $table->foreignId(column: 'contest_id')->after('contestant_id')->constrained()->restrictOnDelete();
            $table->string('voter_token')->nullable()->after('user_id')->index();
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contest_id');
            $table->dropIndex(['voter_token']);
            $table->dropColumn('voter_token');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
