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
        if (!Schema::hasTable('dartboards')) {
            Schema::create('dartboards', function (Blueprint $table)
            {
                $table->id();
                $table->uuid('uuid')
                    ->unique()  // note that columns defined as primary keys or unique keys are automatically indexed in MySQL
                    ->comment('used for audit logging and api');
                $table->string('name');
                $table->string('description')
                    ->nullable()
                    ->default('This is a dart gamemode');
                $table->string('image_path')
                    ->nullable()
                    ->comment('Path to dartboard image');
                $table->boolean('active')
                    ->default(false)
                    ->comment('whether or not the gamemode is selectable');
                $table->foreignId('owned_by')
                    ->nullable()
                    ->comment('Owner/Maintainer of this board.')
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->timestamps();
            });

            Schema::table('games', function (Blueprint $table)
            {
                $table->after('gamemode_id', function ($table)
                {
                    $table->foreignId('dartboard_id')
                        ->nullable()
                        ->constrained('dartboards')
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
        Schema::dropIfExists('dartboards');
    }
};
