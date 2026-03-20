<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_unknown_email_cannot_continue_to_reset_password(): void
    {
        $response = $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'unknown@example.com',
            ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error', 'Email tidak dapat dikenali oleh sistem.');
    }

    public function test_known_email_is_redirected_to_new_password_page(): void
    {
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin-test@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response = $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email,
            ]);

        $response->assertRedirect(route('password.reset'));
        $response->assertSessionHas('password_reset_email', $user->email);
    }

    public function test_reset_password_page_requires_verified_email_session(): void
    {
        $response = $this->get(route('password.reset'));

        $response->assertRedirect(route('password.request'));
    }

    public function test_user_can_save_a_new_password_after_email_verification(): void
    {
        $user = User::create([
            'name' => 'Karyawan Test',
            'email' => 'karyawan-test@example.com',
            'password' => 'password',
            'role' => 'karyawan',
        ]);

        $response = $this->withSession([
            'password_reset_email' => $user->email,
        ])->post(route('password.update'), [
            'password' => 'passwordBaru123',
            'password_confirmation' => 'passwordBaru123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Password baru berhasil disimpan. Silakan login kembali.');
        $response->assertSessionMissing('password_reset_email');

        $user->refresh();

        $this->assertTrue(Hash::check('passwordBaru123', $user->password));
    }
}