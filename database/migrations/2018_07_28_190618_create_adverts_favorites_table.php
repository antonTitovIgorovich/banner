<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertsFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('adverts_favorites', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('advert_id')->references('id')->on('advert')->onDelete('CASCADE');
            $table->primary(['user_id', 'advert_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('adverts_favorites');
    }
}
