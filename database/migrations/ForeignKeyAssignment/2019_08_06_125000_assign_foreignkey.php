<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AssignForeignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Assign Foreignkey for User Management Table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
        Schema::table('rights', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('role_rights', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('right_id')->references('id')->on('rights');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('user_mngm_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //do nothing
    }
}
