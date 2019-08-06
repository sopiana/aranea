<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMngmAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mngm_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('effective_utc');
            $table->string('source',200);
            $table->integer('source_id',false,true)->nullable();
            $table->enum('type',['CREATE', 'UPDATE', 'DELETE']);
            $table->integer('author',false,true)->nullable();
            $table->string('column',200)->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mngm_audits');
    }
}
