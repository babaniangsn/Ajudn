<?php

namespace Tests\Feature;

use App\Models\Membre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembreBureauTest extends TestCase
{
    use RefreshDatabase;

    public function test_bureau_page_displays_members_with_roles(): void
    {
        Membre::factory()->create([
            'prenom' => 'Babacar',
            'nom' => 'Ndiaye',
            'role' => 'Président',
            'statut' => 'actif',
        ]);

        $response = $this->get(route('membres.bureau'));

        $response->assertOk();
        $response->assertSee('Bureau de l\'association');
        $response->assertSee('Président');
    }

    public function test_member_can_be_created_with_role(): void
    {
        $response = $this->post(route('membres.store'), [
            'prenom' => 'Awa',
            'nom' => 'Diop',
            'telephone' => '771234567',
            'date_adhesion' => now()->toDateString(),
            'statut' => 'actif',
            'carte' => true,
            'role' => 'Trésorière',
        ]);

        $response->assertRedirect(route('membres.index'));
        $this->assertDatabaseHas('membres', ['role' => 'Trésorière']);
    }
}
