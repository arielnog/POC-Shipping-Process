<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingTable extends Migration
{
    /**
     * Rn the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
            $table->string('from_postcode')->nullable(false);
            $table->string('to_postcode')->nullable(false);
            $table->float('from_weight')->nullable(false);
            $table->float('to_weight')->nullable(false);
            $table->float('cost')->nullable(false);
            $table->foreignId('file_control_id')->constrained('file_control');
            $table->softDeletes();
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
        Schema::dropIfExists('shipping');
    }
}
