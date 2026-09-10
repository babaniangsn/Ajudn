<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_account_cannot_be_deleted(): void
    {
        $user = User::query()->create([
            'name' => 'Administrateur',
            'email' => 'ajudn@gmail.com',
            'password' => bcrypt('Ajudn2026'),
        ]);

        try {
            $user->delete();
            $this->fail('Le compte administrateur ne doit pas pouvoir être supprimé.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('ajudn@gmail.com', $exception->getMessage());
            $this->assertStringContainsString('protégé', $exception->getMessage());
        }

        $this->assertDatabaseHas('users', ['email' => 'ajudn@gmail.com']);
    }
}
