<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('shortener.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_url')->unique();
            $table->string('code')->nullable()->unique();
            $table->integer('requested_count')->default(0);
            $table->integer('used_count')->default(0);
            $table->timestamp('last_requested')->nullable();
            $table->timestamp('last_used')->nullable();
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
        Schema::dropIfExists(config('shortener.table'));
    }
}
