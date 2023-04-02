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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('sent_to')->default(1);
            $table->integer('noti_type');
            $table->string('title');
            $table->text('message');
            $table->longText('detail')->nullable();
            $table->dateTime('schedule_date')->nullable()->index();
            $table->boolean('send_status')->default(0)->index();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
