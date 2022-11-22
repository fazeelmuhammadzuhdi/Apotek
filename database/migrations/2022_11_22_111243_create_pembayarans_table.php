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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nota', 15);
            $table->decimal('total', 9, 2);
            $table->decimal('diskon', 9, 2);
            $table->decimal('pajak', 9, 2);
            $table->decimal('dibayar', 9, 2);
            $table->decimal('kembali', 9, 2);
            $table->enum('status', ['Cash', 'Hutang']);
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
        Schema::dropIfExists('pembayarans');
    }
};
