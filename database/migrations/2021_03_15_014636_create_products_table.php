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
            $table->bigIncrements('id');
            $table->char('barcode', 13)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 8, 2);
            $table->decimal('sale_price', 8, 2);
            $table->integer('stock');
            $table->integer('minimum_stock');
            $table->string('photo')->default('products/no-image-available.jpg');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreignId('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');
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