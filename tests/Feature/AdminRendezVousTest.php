<?php

namespace Tests\Feature;

use App\Models\Creneau;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRendezVousTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Admin confirme un rendez-vous
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_confirm_rendezvous(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::create([
            'date' => '2026-09-01',
            'heure_debut' => '10:00',
            'duree' => 30,
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(
                route(
                    'admin.rendezvous.confirmer',
                    $rendezVous
                )
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'confirme',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin annule un rendez-vous
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_cancel_rendezvous(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::create([
            'date' => '2026-09-02',
            'heure_debut' => '11:00',
            'duree' => 30,
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(
                route(
                    'admin.rendezvous.annuler',
                    $rendezVous
                )
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'annule',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Client ne peut pas confirmer
    |--------------------------------------------------------------------------
    */

    public function test_client_cannot_confirm_rendezvous(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::create([
            'date' => '2026-09-03',
            'heure_debut' => '12:00',
            'duree' => 30,
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this
            ->actingAs($client)
            ->patch(
                route(
                    'admin.rendezvous.confirmer',
                    $rendezVous
                )
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'en_attente',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Client ne peut pas annuler via route Admin
    |--------------------------------------------------------------------------
    */

    public function test_client_cannot_cancel_rendezvous_from_admin_route(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::create([
            'date' => '2026-09-04',
            'heure_debut' => '13:00',
            'duree' => 30,
        ]);

        $rendezVous = RendezVous::create([
            'user_id' => $client->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this
            ->actingAs($client)
            ->patch(
                route(
                    'admin.rendezvous.annuler',
                    $rendezVous
                )
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rendezVous->id,
            'statut' => 'en_attente',
        ]);
    }
}