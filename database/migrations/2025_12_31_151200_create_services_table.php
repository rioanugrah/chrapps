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
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('server_id');
            $table->string('service_code');
            $table->string('username');
            $table->string('password');
            $table->date('expired_date');
            $table->string('ip_address');
            $table->text('l2tp_config')->nullable();
            $table->text('sstp_config')->nullable();
            $table->enum('status',['Active','InActive','Expired'])->default('InActive');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services_nat_rule', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_id');
            $table->string('port',100);
            $table->string('to_addresses',100);
            $table->string('to_port',100);
            $table->enum('status',['Active','InActive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('services_domain', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_id');
            $table->text('domain');
            $table->string('port',100);
            $table->enum('status',['Active','InActive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('services_nat_rule');
        Schema::dropIfExists('services_domain');
    }
};
