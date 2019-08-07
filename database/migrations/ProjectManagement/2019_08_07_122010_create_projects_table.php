<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix',10);
            $table->string('name',200);
            $table->string('summary',400)->nullable();
            $table->text('description')->nullable();
            $table->string('avatar',100);
            $table->integer('owner_id',false,true);
            $table->integer('kind_id',false,true)->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('opt_request')->nullable();
            $table->boolean('opt_requirement')->nullable();
            $table->boolean('opt_testcase')->nullable();
            $table->boolean('opt_testexecution')->nullable();
            $table->boolean('opt_bugs')->nullable();
            $table->integer('notif_setting',false,true);
            $table->string('api_key',255);
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
        Schema::dropIfExists('projects');
        Schema::enableForeignKeyConstraints();
    }
}
