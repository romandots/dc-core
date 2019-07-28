<?php
/**
 * File: 2019_07_26_154006_create_intents_table.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-26
 * Copyright (c) 2019
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIntentsTable
 */
class CreateIntentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('intents', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id')->index();
            $table->unsignedInteger('manager_id')->nullable()->index();
            $table->unsignedInteger('event_id');
            $table->enum('event_type', \App\Models\Intent::EVENT_TYPES)
                ->default(\App\Models\Course::class);
            $table->enum('status', \App\Models\Intent::STATUSES)
                ->default(\App\Models\Intent::STATUS_EXPECTING)
                ->index();
            $table->timestamps();

            $table->index(['event_id', 'event_type'], 'morph_intents_event_id');

            $table->foreign('student_id')
                ->references('id')
                ->on(\App\Models\Student::TABLE)
                ->onDelete('restrict');

            $table->foreign('manager_id')
                ->references('id')
                ->on(\App\Models\User::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('intents');
    }
}