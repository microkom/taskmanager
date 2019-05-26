<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeingKeysTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('position_id')->references('id')->on('positions');
        });
        
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('position_id')->references('id')->on( 'positions');
        });
        
        Schema::table('task_positions', function (Blueprint $table) {
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('task_id')->references('id')->on('tasks');
        });
        
        Schema::table('absences', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        }); 
        
        /*         Schema::table('employee_exclusions', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('task_id')->references('id')->on('tasks');
        }); */
    }
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down() {
        
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropForeign('subcategories_categoryid_foreign');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_userid_foreign');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_categoryid_foreign');
            $table->dropForeign('products_subcategoryid_foreign');
            $table->dropForeign('products_providerid_foreign');
            $table->dropForeign('products_taxesid_foreign');
        });
        Schema::table('order_lines', function (Blueprint $table) {
            $table->dropForeign('order_lines_orderid_foreign');
            $table->dropForeign('order_lines_productid_foreign');
        });
        Schema::table('provider_orders', function (Blueprint $table) {
            $table->dropForeign('provider_orders_providerid_foreign');
        });
        Schema::table('provider_order_lines', function (Blueprint $table) {
            $table->dropForeign('provider_order_lines_providerorderid_foreign');
            $table->dropForeign('provider_order_lines_productid_foreign');
        });
    }
}
