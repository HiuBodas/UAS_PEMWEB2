<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicDashboardTest extends TestCase
{
    public function test_guest_can_view_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect();
        $response->assertLocation('/login');
    }

    public function test_login_page_displays_register_link(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Register');
    }
}
