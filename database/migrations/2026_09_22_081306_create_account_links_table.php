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
        Schema::create('account_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('linked_account_id');
            $table->foreign('linked_account_id')->references('id')->on('accounts')->onDelete('restrict')->onUpdate('cascade');
            $table->enum('link_type', ['login_via', 'registered_with']);
            $table->unique(['account_id', 'linked_account_id', 'link_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_links');
    }
};
