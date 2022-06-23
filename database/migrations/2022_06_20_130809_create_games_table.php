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
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table)
            {
                $table->id();
                $table->uuid()
                    ->unique()  // note that columns defined as primary keys or unique keys are automatically indexed in MySQL
                    ->comment('used for audit logging and api');
                $table->string('name');
                $table->string('description')
                    ->default('A dart game.')
                    ->nullable();
                $table->tinyInteger('current_leg')
                    ->nullable();
                $table->tinyInteger('total_legs')
                    ->nullable();
                $table->enum('state', ['STARTED', 'RUNNING', 'CONTINUED', 'PAUSED', 'FINISHED', 'STOPPED', 'CLOSED'])
                    ->comment('STARTED = Game got created and is ready; RUNNING = Game is currently going; CONTINUED = Game is running again after PAUSED or STOPPED state; PAUSED = Game is temporarly paused by a Gamemaster; FINISHED = Game is done; STOPPED = Game paused for a longer period by a Gamemaster; CLOSED = Game got closed by system');
                $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->foreignId('modified_by')
                    ->nullable()
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->timestamps();
            });

            Schema::table('users', function (Blueprint $table)
            {
                $table->after('role_id', function ($table)
                {
                    $table->foreignId('game_id')
                        ->nullable()
                        ->constrained('games')
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
        Schema::dropIfExists('games');
    }
};
