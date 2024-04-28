<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::rename('timesheets', 'old_timesheets');

    Schema::create('timesheets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('calendar_id')->constrained();
      $table->foreignId('user_id')->constrained();
      $table->enum('type', ['work', 'pause'] )->default('work');
      $table->timestamp('day_in')->nullable();
      $table->timestamp('day_out')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
