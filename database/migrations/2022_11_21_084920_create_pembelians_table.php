<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('faktur', 20);
            $table->string('item', 30);
            $table->decimal('harga', 9, 2);
            $table->integer('qty');
            $table->date('tanggal');
            $table->decimal('totalkotor', 9, 2);
            $table->decimal('pajak', 9, 2);
            $table->decimal('diskon', 9, 2);
            $table->decimal('totalbersih', 9, 2);
            $table->text('keterangan');
            $table->unsignedBigInteger('supplier');
            $table->foreign('supplier')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('admin');
            $table->foreign('admin')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('pembelians');
    }
};
