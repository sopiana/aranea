<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id',false,true);
            $table->integer('submitter_id',false,true);
            $table->bigInteger('test_suite_id', false, true)->nullable();
            $table->string('version',200);
            $table->integer('status',false,true);
            $table->string('summary',2000);
            $table->text('description')->nullable();
            $table->string('objective',2000)->nullable();
            $table->string('preconditions',2000)->nullable();
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
        Schema::dropIfExists('test_cases');
        Schema::enableForeignKeyConstraints();
    }
}
