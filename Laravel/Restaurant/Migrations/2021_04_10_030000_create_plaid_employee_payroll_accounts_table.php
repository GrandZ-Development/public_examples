<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaidEmployeePayrollAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('plaid_employee_payroll_accounts');

        Schema::create('plaid_employee_payroll_accounts', function (Blueprint $table) {

            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('account_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plaid_employee_payroll_accounts');
    }
}
