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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('status', ["pending", "running", "complete" , "stoped"])->default("pending");

            $table->integer("from")->default(0);
            $table->integer("to")->default(0);

            $table->dateTime("started_at");
            $table->dateTime("ended_at")->nullable();

            $table->foreignId("device_id")->constrained("devices");
            $table->foreignId("message_id")->constrained("messages");

            $table->foreignId('user_id')->constrained()->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
