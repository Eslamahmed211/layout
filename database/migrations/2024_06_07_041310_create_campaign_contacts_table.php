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
        Schema::create('campaign_contacts', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('phone');
            $table->enum('status', ["pending", "success", "failed" , "sending"])->default("pending");

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);

            $table->foreignUuid('campaign_id')->constrained("campaigns")->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_contacts');
    }
};
