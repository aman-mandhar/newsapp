<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
       // User Roles (e.g. Admin, Promoter, User, etc.)
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert default roles right after table is created
        DB::table('user_roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'Subscriber'],
            ['name' => 'Media Partner'],
            ['name' => 'Employee'],
        ]);

        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->default('Not Defined');
            $table->string('mobile_number', 10)->unique();

            // Role
            $table->unsignedBigInteger('user_role_id')->default(2);

            // Auth
            $table->string('email', 255)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);

            // location
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();

            $table->string('session_token', 255)->nullable()->unique();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->cascadeOnDelete();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_roles');
    }
};
