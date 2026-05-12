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
        Schema::create('id_schedulings', function (Blueprint $table) {
            $table->id();
            $table->string('school_year');
            $table->string('student_no');
            $table->string('guardian_name');
            $table->string('guardian_contact_no');
            $table->string('picture_id');
            $table->string('e_signature');
            $table->string('status');
            $table->string('pick_up_date')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_schedulings');
    }
};
