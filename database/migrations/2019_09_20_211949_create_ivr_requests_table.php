<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvrRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivr_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid');
            $table->string('state');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('phone');
            $table->text('metadata');

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
        Schema::dropIfExists('ivr_requests');
    }
}
