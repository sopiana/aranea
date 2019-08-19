<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',array(''));//TODO
            $table->integer('status_id',false,true);
            $table->integer('detected_release_id',false,true);
            $table->integer('resolved_release_id',false,true);
            $table->integer('verified_release_id',false,true);
            $table->integer('submitter_id',false,true);
            $table->enum('visibility',array('VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT'))->default('VISIBILITY_NONE');
            $table->integer('assignee',false,true);
            $table->enum('priority',array(''));//TODO
            $table->enum('severity',array(''));//TODO
            $table->integer('last_author',false,true)->nullable();
            $table->text('description');
            $table->text('note');
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
        Schema::dropIfExists('bugs');
        Schema::enableForeignKeyConstraints();
    }
}
