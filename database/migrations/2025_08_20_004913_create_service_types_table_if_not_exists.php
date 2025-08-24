<?php
// database/migrations/xxxx_create_service_types_table_if_not_exists.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('service_types')) {
            Schema::create('service_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->boolean('requires_file')->default(false);
                $table->text('file_requirements')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('estimated_days')->default(3);
                $table->timestamps();

                $table->index(['is_active']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('service_types');
    }
};
