<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_cannot_access_admin_rendezvous_page(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
        ]);

        $this->actingAs($client)
            ->get('/admin/rendezvous')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_rendezvous_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/admin/rendezvous')
            ->assertOk();
    }

    public function test_guest_cannot_access_admin_rendezvous_page(): void
    {
        $this->get('/admin/rendezvous')
            ->assertRedirect('/login');
    }
}