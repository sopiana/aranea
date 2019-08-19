<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_executions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('build_id',false,true);
            $table->integer('tester_id',false,true);
            $table->timestamp('executed_at')->nullable();
            $table->integer('status',false,true);
            $table->bigInteger('test_case_id',false,true);
            $table->smallInteger('test_case_version',false,true);
            $table->enum('execution_type',array(''));//TODO
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('test_executions');
        Schema::enableForeignKeyConstraints();
    }
}
