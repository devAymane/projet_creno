<?php

namespace Tests\Feature;

use App\Models\Creneau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreneauTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_creneaux(): void
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        Creneau::factory()->count(3)->create();

        $response = $this->actingAs($user)
            ->get(route('creneaux.index'));

        $response->assertOk();
        $response->assertViewIs('creneaux.index');
    }

    public function test_guest_cannot_view_creneaux(): void
    {
        $this->get(route('creneaux.index'))
            ->assertRedirect('/login');
    }

    public function test_admin_can_create_creneau(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $data = [
            'date' => now()->addDays(2)->toDateString(),
            'heure_debut' => '10:00',
            'duree' => 30,
        ];

        $response = $this->actingAs($admin)
            ->post(route('creneaux.store'), $data);

        $response->assertRedirect(route('creneaux.index'));

$this->assertDatabaseHas('creneaux', [
    'date' => $data['date'] . ' 00:00:00',
    'heure_debut' => $data['heure_debut'],
    'duree' => $data['duree'],
]);
    }

    public function test_client_cannot_create_creneau(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $data = [
            'date' => now()->addDays(2)->toDateString(),
            'heure_debut' => '10:00',
            'duree' => 30,
        ];

        $this->actingAs($client)
            ->post(route('creneaux.store'), $data)
            ->assertForbidden();

        $this->assertDatabaseCount('creneaux', 0);
    }

    public function test_admin_can_delete_available_creneau(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->addDay()->toDateString(),
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('creneaux.destroy', $creneau));

        $response->assertRedirect(route('creneaux.index'));

        $this->assertDatabaseMissing('creneaux', [
            'id' => $creneau->id,
        ]);
    }
}