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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('password')->nullable()->constrained();
            $table->string('phone_number')->nullable()->after('role_id');
            $table->string('address')->nullable()->after('phone_number');
            $table->string('profile_photo')->nullable()->after('address');
            $table->string('nim')->nullable()->unique()->after('profile_photo');
            $table->string('nip')->nullable()->unique()->after('nim');
            $table->string('department')->nullable()->after('nip');
            $table->string('semester')->nullable()->after('department');
            $table->foreignId('company_id')->nullable()->after('semester');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['company_id']);
            
            $table->dropColumn([
                'role_id',
                'phone_number',
                'address',
                'profile_photo',
                'nim',
                'nip',
                'department',
                'semester',
                'company_id',
                'deleted_at',
            ]);
        });
    }
};
