<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_relationships', function (Blueprint $table) {
            $table->id();
            
            // Parent data of the relation 
            $table->foreignId("data_id")->constrained('datas')->onDelete('cascade');

            // Value of the relation if it's a Post or a Post type
            $table->foreignId("post_id")->nullable()->constrained();

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
        Schema::dropIfExists('data_relationships');
    }
}
