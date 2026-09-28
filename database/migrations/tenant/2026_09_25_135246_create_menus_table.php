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
        if (! Schema::connection('tenant')->hasTable('menus')) {
            Schema::connection('tenant')->create('menus', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('url')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->integer('urutan')->default(0);
                $table->boolean('is_aktif')->default(true);
                $table->string('type')->default('link'); // 'link', 'dropdown'
                $table->timestamps();

                $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('menus');
    }
};
