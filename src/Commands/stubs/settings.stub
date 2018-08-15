<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create the Settings Table
         *
         */
        Schema::table('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')
                ->nullable();
            $table->text('value')
                ->nullable();

            $table->index('key', 'settings_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}