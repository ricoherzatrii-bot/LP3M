<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('password');
            }
        });

        if (Schema::hasTable('users')) {
            $users = \DB::table('users')->get();
            foreach ($users as $user) {
                if (empty($user->username)) {
                    $username = str_replace([' ', '@', '.', ','], '', strtolower($user->name ?? 'user'));
                    $username = preg_replace('/[^a-z0-9]/', '', $username);
                    $base = $username ?: 'user';
                    $candidate = $base;
                    $counter = 1;
                    while (\DB::table('users')->where('username', $candidate)->where('id', '!=', $user->id)->exists()) {
                        $candidate = $base . $counter;
                        $counter++;
                    }
                    \DB::table('users')->where('id', $user->id)->update(['username' => $candidate]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
        });
    }
};
