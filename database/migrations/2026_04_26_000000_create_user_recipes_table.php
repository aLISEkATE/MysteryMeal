<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_recipes', function (Blueprint $table) {
            // Add any missing columns
            if (!Schema::hasColumn('user_recipes', 'cooking_time')) {
                $table->integer('cooking_time')->nullable()->after('instructions');
            }
            if (!Schema::hasColumn('user_recipes', 'image')) {
                $table->string('image')->nullable()->after('cooking_time');
            }
        });
    }

    public function down()
    {
        Schema::table('user_recipes', function (Blueprint $table) {
            $table->dropColumn(['cooking_time', 'image']);
        });
    }
};