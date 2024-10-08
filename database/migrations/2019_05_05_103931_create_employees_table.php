<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('position_id')->index();
            $table->unsignedBigInteger('scale_number')->nullable();
            /* $table->unsignedBigInteger('user_id')->nullable(); */
            $table->string('dni')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('cip_code')->nullable();
            $table->string('driver_license')->nullable();
             $table->unsignedBigInteger('role_id')->default('2')->index();
            $table->timestamps();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
