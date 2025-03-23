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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string(column:'name', length:255);
            $table->string(column:'slug', length:255);
            $table->string(column:'cover_path', length:255);
            $table->string(column:'thumbnail_path', length:255);
            $table->boolean(column:'auto_approval')->default(value:true);
            $table->text(column:'about')->nullable();
            $table->foreignId(column:'user_id')->constrained(table:'users');
            $table->timestamp(column:'deleted_at')->nullable();
            $table->foreignId(column:'deleted_by')->nullable()->constrained(table:'users');
            $table->timestamp(column:'created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
