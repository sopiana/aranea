<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id',false,true);
            $table->integer('submitter_id',false,true);
            $table->bigInteger('folder_id', false, true)->nullable();
            $table->integer('status',false,true);
            $table->string('summary',2000);
            $table->text('description')->nullable();
            $table->enum('visibility',array('VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT'))->default('VISIBILITY_NONE');
            $table->boolean('is_active')->default(true);
            $table->integer('assignee',false,true)->nullable();
            $table->enum('priority',array('PRIORITY_LOW','PRIORITY_MEDIUM','PRIORITY_HIGH','PRIORITY_URGENT'))->default('PRIORITY_LOW');
            $table->timestamp('due_date')->nullable();
            $table->integer('attachment')->nullable();
            $table->integer('last_author', false, true);
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
        Schema::dropIfExists('requirements');
        Schema::enableForeignKeyConstraints();
    }
}
