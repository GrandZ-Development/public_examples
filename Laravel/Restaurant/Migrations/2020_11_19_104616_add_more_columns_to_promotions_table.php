<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('time')->nullable()->change();
            $table->renameColumn('time', 'start_time');
            $table->time('end_time')->nullable();
            $table->boolean('repeat')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
           $table->dropColumn(['end_time','repeat']);
           $table->renameColumn('start_time', 'time');
        });
    }
}
