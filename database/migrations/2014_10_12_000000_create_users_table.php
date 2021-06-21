<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string("image")->nullable();
            $table->string('email')->unique();
            $table->string("user_type",20)->default("user");
            $table->boolean("is_active")->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum("gender",["Male","Female"])->default("Male");
            $table->date("date_of_birth")->nullable();
            $table->boolean("send_notifications")->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
