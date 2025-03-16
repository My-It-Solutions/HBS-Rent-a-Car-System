<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ownerpayment', function (Blueprint $table) {
            $table->json('receipt')->nullable()->after('acc_no');
        });
    }

    public function down(): void
    {
        Schema::table('ownerpayment', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }
};

