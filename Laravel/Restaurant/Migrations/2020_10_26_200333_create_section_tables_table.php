<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_tables', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('section_id')->index();
            $table->string('table_id')->index();
            $table->timestamps();


            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');


            $table->foreign('table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_tables');
    }
}
