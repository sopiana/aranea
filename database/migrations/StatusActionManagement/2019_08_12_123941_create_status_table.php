<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_entry_point')->default(false);
            $table->enum('type',array('TYPE_REQUEST','TYPE_REQUIREMENT', 'TYPE_TEST_CASE', 'TYPE_TEST_EXECUTION','TYPE_RELEASE', 'TYPE_BUGS','TYPE_TASK','TYPE_EPIC','TYPE_OTHER'));
            $table->string('key')->unique();
            $table->string('name',255);
            $table->text('info')->nullable();
            $table->integer('last_author',false,true)->nullable();
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
        Schema::dropIfExists('status');
        Schema::enableForeignKeyConstraints();
    }
}
