<?php

namespace Tests\Feature\Auth;

use App\Jobs\SendMailJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === $user->email
            && $job->subject === 'Reset Password Akun Ayoto Nippon');
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->get('/reset-password/'.$token);

        $response->assertStatus(200);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        Queue::assertPushed(SendMailJob::class, fn ($job) => $job->to === $user->email
            && $job->subject === 'Password akun Ayoto Nippon berhasil diubah');
    }
}
