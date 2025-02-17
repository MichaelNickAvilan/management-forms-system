<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id_form');
            $table->unsignedInteger('id_system');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('name_form');
            $table->string('description_form');

            $table->timestamps();
        });
        Schema::table('forms', function (Blueprint $table) {
            $table->foreign('id_system')->references('id_system')->on('systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
