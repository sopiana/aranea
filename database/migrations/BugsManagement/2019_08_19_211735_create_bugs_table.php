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
            $table->integer('project_id',false,true);
            $table->enum('type',array('TYPE_BUG', 'TYPE_ISSUE', 'TYPE_LIMITATION'));
            $table->string('summary',2000);
            $table->integer('status',false,true);
            $table->bigInteger('detected_release_id',false,true);
            $table->bigInteger('resolved_release_id',false,true)->nullable();
            $table->bigInteger('verified_release_id',false,true)->nullable();
            $table->integer('submitter_id',false,true);
            $table->enum('visibility',array('VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT'))->default('VISIBILITY_NONE');
            $table->integer('assignee',false,true)->nullable();
            $table->enum('priority',array('PRIORITY_LOW','PRIORITY_MEDIUM','PRIORITY_HIGH','PRIORITY_URGENT'));
            $table->enum('severity',array('SEVERITY_LOW','SEVERITY_MEDIUM','SEVERITY_HIGH','SEVERITY_CRITICAL'));
            $table->text('description');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('bugs');
        Schema::enableForeignKeyConstraints();
    }
}
