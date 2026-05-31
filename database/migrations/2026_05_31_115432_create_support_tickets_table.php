<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('subject'); // тема обращения
            $table->text('message');
            $table->string('attachment')->nullable(); // файл
            $table->enum('status', ['new', 'in_progress', 'resolved'])->default('new');
            $table->text('admin_reply')->nullable(); // ответ админа
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};