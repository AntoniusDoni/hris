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
        Schema::create('detail_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedules_id');
            $table->date('date');
            $table->uuid('employee_id');
            $table->uuid('division_id')->nullable();
            $table->uuid('position_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_schedules');
    }
};
