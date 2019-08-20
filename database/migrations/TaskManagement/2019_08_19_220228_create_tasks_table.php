<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->enum('type',array(''));//TODO
            $table->integer('sprint_id',false,true);
            $table->integer('submitter_id',false,true);
            $table->enum('visibility',array('VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT'))->default('VISIBILITY_NONE');
            $table->boolean('is_active')->default(true);
            $table->integer('assignee',false,true)->nullable();
            $table->enum('priority',array('PRIORITY_LOW','PRIORITY_MEDIUM','PRIORITY_HIGH','PRIORITY_URGENT'))->default('PRIORITY_LOW');
            $table->string('summary',2000);
            $table->text('description');
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
        Schema::dropIfExists('tasks');
    }
}
