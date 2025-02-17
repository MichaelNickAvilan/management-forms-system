<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id_field');
            $table->unsignedInteger('id_form');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('name_field');
            $table->enum('type_field', ['text', 'text_area', 'rich_text', 'number', 'date', 'date_range'. 'combo']);
            $table->enum('combo_render_as', ['not_apply', 'radio_set', 'box_set', 'select']);
            $table->string('description_field');
            $table->string('position_field');
            $table->string('settings_field');
            $table->timestamps();
        });
        Schema::table('fields', function (Blueprint $table) {
            $table->foreign('id_form')->references('id_form')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
