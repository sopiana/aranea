<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleaseBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_builds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('release_id', false, true);
            $table->integer('build_number', false, true)->default(1);
            $table->text('description')->nullable();
            $table->text('build_log')->nullable();
            $table->enum('status',array('BUILD_ABORTED','BUILD_FAILED','BUILD_SUCCESS','BUILD_UNSTABLE'));
            $table->integer('author',false,true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('release_builds');
        Schema::enableForeignKeyConstraints();
    }
}
