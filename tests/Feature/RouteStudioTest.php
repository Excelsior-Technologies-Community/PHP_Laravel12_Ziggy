<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteStudioTest extends TestCase
{
    public function test_route_dispatcher_page_loads(): void
    {
        $response = $this->get(route('route.dispatcher'));
        $response->assertStatus(200);
        $response->assertSee('API Request Dispatcher', false);
    }

    public function test_route_snippets_page_loads(): void
    {
        $response = $this->get(route('route.snippets'));
        $response->assertStatus(200);
        $response->assertSee('Multi-Framework Code Snippet Studio', false);
    }

    public function test_route_tree_page_loads(): void
    {
        $response = $this->get(route('route.tree'));
        $response->assertStatus(200);
        $response->assertSee('Real-Time Fuzzy Route Search &amp; Tree Map', false);
    }

    public function test_route_telemetry_page_loads(): void
    {
        $response = $this->get(route('route.telemetry'));
        $response->assertStatus(200);
        $response->assertSee('Client-Side Route Telemetry &amp; Analytics', false);
    }

    public function test_route_cheatsheet_page_loads(): void
    {
        $response = $this->get(route('route.cheatsheet'));
        $response->assertStatus(200);
        $response->assertSee('Ziggy Route Architecture Manual', false);
    }

    public function test_api_users_endpoints(): void
    {
        $response = $this->getJson(route('api.users.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data']);

        $show = $this->getJson(route('api.users.show', ['id' => 1]));
        $show->assertStatus(200);
        $show->assertJsonStructure(['status', 'data' => ['id', 'name', 'email']]);

        $store = $this->postJson(route('api.users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'QA Engineer'
        ]);
        $store->assertStatus(201);
    }

    public function test_api_health_endpoint(): void
    {
        $response = $this->getJson(route('api.health.check'));
        $response->assertStatus(200);
        $response->assertJson(['status' => 'healthy']);
    }

    public function test_welcome_page_loads_with_studio_links(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Advanced Route Engineering & Analytics Suite', false);
    }
}
