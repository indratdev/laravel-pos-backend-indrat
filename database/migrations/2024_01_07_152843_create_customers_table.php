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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //description
            $table->text('email')->nullable();
            //price
            $table->text('phone')->nullable();
            //stock
            $table->text('address')->nullable();
            //stock
            $table->text('project_id')->nullable();
            //stock
            $table->integer('active')->default(1);
            //stock
            $table->integer('deleted')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
