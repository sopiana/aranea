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
            $table->bigInteger('release_id',false,true);
            $table->text('description')->nullable();
            $table->text('build_log')->nullable();
            $table->enum('status',array('')); //TODO
            $table->integer('last_author',false,true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
