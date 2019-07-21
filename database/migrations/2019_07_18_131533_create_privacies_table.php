<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*=========================
     *
     * | LEGEND
     * | 1 | - all
     * | 2 | - friends
     * | 3 | - no one (only I)
     * | LEGEND DATA BIRTHDAY
     * | 1 | - all
     * | 2 | - day and month
     * | 3 | - year
     * | 4 | - no only
     *
     =========================*/

    public function up()
    {
        Schema::create('privacies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('viewProfil')->default(1);
            $table->integer('viewFriends')->default(1);
            $table->integer('viewDateB')->default(1);
            $table->integer('viewEmail')->default(1);
            $table->integer('viewArticles')->default(1);
            $table->integer('viewPhotos')->default(1);
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
        Schema::dropIfExists('privacies');
    }
}
