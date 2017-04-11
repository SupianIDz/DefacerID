<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notifier', 30);
            $table->string('team', 40);
            $table->string('url', 250);
            $table->string('domain', 50);
            $table->string('ip', 30);
            $table->integer('concept');
            $table->string('technology', 200); // JSON
            $table->string('geolocation', 100);
            $table->text('content');
            $table->enum('home', [0,1]); // 0 = Non Home Attack, 1 = Home Attack
            $table->enum('special', [0,1]); // 0 = Non Government Site, 1 = Government Site
            $table->enum('mass', [0,1]);
            $table->enum('redeface', [0,1]);
            $table->enum('status', [0,1]); // 0 = Onhold, 1 = Published
            $table->datetime('datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
}
