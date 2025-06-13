<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('link_id')->constrained()->cascadeOnDelete();

            // One of these two will be filled
            $table->foreignId('tag_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_tag_id')->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();

            // Optional: prevent duplicates
            $table->unique(['link_id', 'tag_id', 'user_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_tag');
    }
};
