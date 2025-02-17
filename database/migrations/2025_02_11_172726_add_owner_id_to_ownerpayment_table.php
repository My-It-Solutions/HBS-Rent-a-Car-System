<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ownerpayment', function (Blueprint $table) {
            $table->string('owner_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('ownerpayment', function (Blueprint $table) {
            $table->dropColumn('owner_id');
        });
    }
};
