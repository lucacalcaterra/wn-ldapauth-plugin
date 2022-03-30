<?php

namespace LucaCalcaterra\LdapAuth\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class AddLdapColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            $table->string('guid')->unique()->nullable();
            $table->string('domain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            $table->dropColumn(['guid', 'domain']);
        });
    }
}
