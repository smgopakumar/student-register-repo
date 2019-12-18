<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('user_type_id')->default(1)->comment("1-Students , 2-Admin");
            $table->string('image_url')->nullable();
            $table->string('class')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('status')->default(1)->comment("0-Not Active 1-Active");
            $table->tinyInteger('registration_status')->default(0)->comment("0- default , 1-Not Selected 2-Selected");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
