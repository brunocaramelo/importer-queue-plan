<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsProductsStatus extends Migration
{
    public function up()
    {
        Schema::create('jobs_products_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('file_name');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->longText('return_message')->nullable();
            $table->enum('status_process', ['pendent','success' ,'fail']);
            $table->enum('status_import', ['pendent','success' ,'fail']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs_products_status');
    }
}
