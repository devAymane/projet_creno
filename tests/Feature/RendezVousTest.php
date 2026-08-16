<?php

namespace Tests\Feature;

use App\Models\Creneau;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RendezVousTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_reserve_available_creneau(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->addDay()->toDateString(),
        ]);

        $response = $this->actingAs($client)
            ->post(route('rendezvous.store', $creneau));

        $response->assertRedirect(route('rendezvous.index'));

        $this->assertDatabaseHas('rendez_vous', [
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);
    }

    public function test_client_cannot_reserve_already_reserved_creneau(): void
    {
        $client1 = User::factory()->create([
            'role' => 'client',
        ]);

        $client2 = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->addDay()->toDateString(),
        ]);

        RendezVous::create([
            'user_id' => $client1->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($client2)
            ->post(route('rendezvous.store', $creneau));

        $response
            ->assertRedirect()
            ->assertSessionHas('error', 'Ce créneau est déjà réservé.');

        $this->assertDatabaseCount('rendez_vous', 1);
    }

    public function test_client_cannot_reserve_past_creneau(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->subDay()->toDateString(),
        ]);

        $response = $this->actingAs($client)
            ->post(route('rendezvous.store', $creneau));

        $response
            ->assertRedirect()
            ->assertSessionHas('error', 'Ce créneau est déjà passé.');

        $this->assertDatabaseCount('rendez_vous', 0);
    }

    public function test_client_can_cancel_own_rendezvous(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->addDay()->toDateString(),
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($client)
            ->delete(route('rendezvous.destroy', $rendezVous));

        $response
            ->assertRedirect()
            ->assertSessionHas(
                'success',
                'Rendez-vous annulé avec succès.'
            );

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'annule',
        ]);
    }

    public function test_client_cannot_cancel_another_client_rendezvous(): void
    {
        $client1 = User::factory()->create([
            'role' => 'client',
        ]);

        $client2 = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => now()->addDay()->toDateString(),
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client1->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $this->actingAs($client2)
            ->delete(route('rendezvous.destroy', $rendezVous))
            ->assertForbidden();

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'en_attente',
        ]);
    }
}