<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',500);
            $table->enum('type',array('REL_TYPE_MAJOR','REL_TYPE_MINOR','REL_TYPE_SPRINT'));//TODO
            $table->integer('project_id',false,true);
            $table->integer('status',false,true);
            $table->integer('submitter_id',false,true);
            $table->integer('owner_id',false,true);
            $table->string('version',200);
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->text('info')->nullable();
            $table->text('note')->nullable();
            $table->integer('last_build_number',false, true)->default(0);
            $table->integer('last_author',false,true)->nullable();
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
        Schema::dropIfExists('releases');
        Schema::enableForeignKeyConstraints();
    }
}
