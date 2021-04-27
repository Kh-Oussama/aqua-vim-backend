<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('description');
            $table->string('mark_id');
            $table->double('debit_max');
            $table->double('hmt_max');
            $table->double('power');
            $table->double('liquid_temperature');
            $table->text('engine_description');
            $table->text('pump_description');
            $table->text('voltage_description');
            $table->integer('productsSubcategory_id');
            $table->integer('pdf_path');
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
        Schema::dropIfExists('products');
    }
}
