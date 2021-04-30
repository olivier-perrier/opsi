<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_values', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->foreignId("list_id")->nullable()->constrained()->onDelete('cascade');
            $table->foreignId("data_id")->nullable()->constrained('datas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_values');
    }
}
