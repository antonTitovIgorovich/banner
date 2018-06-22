<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity\User;

class AddUserVerification extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status', 16);
            $table->string('verify_token')->nullable()->unique();
        });

        DB::table('users')->update(['status' => User::STATUS_ACTIVE]);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('verify_token');
        });
    }
}
