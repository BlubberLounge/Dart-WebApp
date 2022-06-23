<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('gamemodes')) {
            Schema::create('gamemodes', function (Blueprint $table)
            {
                $table->id();
                $table->string('name');
                $table->string('description')
                    ->nullable()
                    ->default('This is a dart gamemode');
                $table->string('icon')
                    ->nullable()
                    ->comment('Font Awesome 6 icon');
                $table->boolean('active')
                    ->default(false)
                    ->comment('whether or not the gamemode is selectable when starting a game');
                $table->timestamps();
            });
            
            Schema::table('games', function (Blueprint $table)
            {
                $table->after('state', function ($table)
                {
                    $table->foreignId('gamemode_id')
                        ->nullable()
                        ->constrained('gamemodes')
                        ->onUpdate('cascade')
                        ->onDelete('cascade'); 
                });
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('games'))
        {
            Schema::table('games', function (Blueprint $table) {
                $table->dropForeign(['gamemode_id']);
            });
        }

        Schema::dropIfExists('gamemodes');
    }
};
