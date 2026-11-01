<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->text('activities')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('rccm')->nullable();
            $table->date('rccm_date')->nullable();
            $table->string('ifu')->nullable();
            $table->string('accent_color')->default('#16a34a'); // vert par défaut
            $table->text('footer_message')->nullable();
            $table->text('default_contract_text')->nullable();
            $table->uuid('city_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
