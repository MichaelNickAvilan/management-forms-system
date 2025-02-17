<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->increments('id_system');
            $table->unsignedInteger('id_company');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('name_system');
            $table->string('description_system');
            $table->string('url_system');
            $table->timestamps();
        });
        Schema::table('systems', function (Blueprint $table) {
            $table->foreign('id_company')->references('id_company')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systems');
    }
}
