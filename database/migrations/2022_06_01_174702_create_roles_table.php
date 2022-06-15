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
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')
                    ->nullable();
                $table->timestamps();
            });

            Schema::table('users', function (Blueprint $table) {
                $table->after('password', function ($table) {
                    $table->foreignId('role_id')
                        ->nullable()
                        ->constrained('roles')
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
        Schema::dropIfExists('roles');

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
            });
        }
    }
};
