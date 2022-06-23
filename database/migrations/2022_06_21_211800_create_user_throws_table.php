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
        if (!Schema::hasTable('user_throws'))
        {
            Schema::create('user_throws', function (Blueprint $table)
            {
                $table->id();
                $table->uuid()
                    ->unique()  // note that columns defined as primary keys or unique keys are automatically indexed in MySQL
                    ->comment('used for api');
                $table->tinyInteger('dart_1')
                    ->nullable();
                $table->tinyInteger('dart_2')
                    ->nullable();
                $table->tinyInteger('dart_3')
                    ->nullable();
                $table->tinyInteger('total')
                    ->nullable()
                    ->unsigned();
                $table->foreignUuid('game_uuid')
                    ->nullable()
                    ->constrained('games', 'uuid')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
                $table->timestamps();
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
        Schema::dropIfExists('user_throws');
    }
};
