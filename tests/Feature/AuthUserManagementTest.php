<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_username_and_password_from_database(): void
    {
        User::create([
            'name' => 'Admin Test',
            'username' => 'admintest',
            'email' => 'admin@test.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'admintest',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_can_create_new_user_from_backend(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@example.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->post('/users', [
            'name' => 'User Baru',
            'username' => 'userbaru',
            'email' => 'userbaru@example.com',
            'password' => 'password123',
            'is_admin' => '0',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'username' => 'userbaru',
            'email' => 'userbaru@example.com',
            'password_plain' => 'password123',
        ]);
    }

    public function test_admin_can_update_user_password_and_plain_password_is_saved(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@example.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $targetUser = User::create([
            'name' => 'Target User',
            'username' => 'targetuser',
            'email' => 'target@example.com',
            'password' => bcrypt('oldsecret'),
            'password_plain' => 'oldsecret',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($admin)->put(route('users.update', $targetUser), [
            'name' => 'Target User',
            'username' => 'targetuser',
            'email' => 'target@example.com',
            'password' => 'newsecret123',
            'is_admin' => '0',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'password_plain' => 'newsecret123',
        ]);

        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check('newsecret123', $targetUser->fresh()->password)
        );
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@example.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $targetUser = User::create([
            'name' => 'Target User',
            'username' => 'targetuser',
            'email' => 'target@example.com',
            'password' => bcrypt('oldsecret'),
            'is_admin' => false,
        ]);

        $response = $this->actingAs($admin)->delete(route('users.destroy', $targetUser));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Pengguna berhasil dihapus.');
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@example.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->from(route('users.index'))
            ->delete(route('users.destroy', $admin));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHasErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}

