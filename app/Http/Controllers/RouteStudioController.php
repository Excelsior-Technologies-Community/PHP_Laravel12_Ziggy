<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteStudioController extends Controller
{
    /**
     * Feature 1: Live Interactive API Request Dispatcher View
     */
    public function dispatcher()
    {
        return view('route-dispatcher');
    }

    /**
     * Feature 4: Multi-Framework Code Snippet Studio View
     */
    public function snippets()
    {
        return view('route-snippets');
    }

    /**
     * Feature 5: Real-Time Fuzzy Route Search & Visual Tree Map View
     */
    public function tree()
    {
        return view('route-tree');
    }

    /**
     * Feature 6: Client-Side Route Telemetry & Analytics View
     */
    public function telemetry()
    {
        return view('route-telemetry');
    }

    /**
     * Feature 7: Executive Route Architecture Cheat Sheet (Printable/PDF)
     */
    public function cheatsheet()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'name' => $route->getName(),
                'methods' => $route->methods(),
                'uri' => $route->uri(),
                'action' => $route->getActionName(),
                'parameters' => $route->parameterNames(),
            ];
        })->filter(fn ($r) => !empty($r['name']))->values();

        return view('route-cheatsheet', compact('routes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Real JSON Mock API Endpoints for Interactive Dispatcher Testing
    |--------------------------------------------------------------------------
    */

    public function apiUsersIndex(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Administrator'],
                ['id' => 2, 'name' => 'Sarah Connor', 'email' => 'sarah@example.com', 'role' => 'Lead Developer'],
                ['id' => 3, 'name' => 'Michael Chen', 'email' => 'mchen@example.com', 'role' => 'DevOps Engineer'],
            ],
            'meta' => ['total' => 3, 'timestamp' => now()->toIso8601String()],
        ]);
    }

    public function apiUsersShow($id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => (int) $id,
                'name' => 'User ' . $id,
                'email' => "user{$id}@example.com",
                'status' => 'active',
                'created_at' => now()->subDays(15)->toDateTimeString(),
            ],
        ]);
    }

    public function apiUsersStore(Request $request): JsonResponse
    {
        $payload = $request->all();

        return response()->json([
            'status' => 'created',
            'message' => 'User successfully registered via Ziggy & Axios call!',
            'created_record' => array_merge([
                'id' => rand(100, 999),
                'created_at' => now()->toIso8601String(),
            ], $payload ?: ['name' => 'Alex Carter', 'email' => 'alex@example.com']),
        ], 201);
    }

    public function apiProductsIndex(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'products' => [
                ['id' => 101, 'title' => 'Cloud Server Standard', 'price' => 29.99, 'in_stock' => true],
                ['id' => 102, 'title' => 'SSD Storage Add-on 500GB', 'price' => 15.00, 'in_stock' => true],
                ['id' => 103, 'title' => 'Kubernetes Pod Gateway', 'price' => 49.00, 'in_stock' => false],
            ],
        ]);
    }

    public function apiProductsShow($id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'product' => [
                'id' => (int) $id,
                'title' => 'Product SKU-' . $id,
                'price' => round(19.99 * ($id % 5 + 1), 2),
                'inventory_status' => 'in_stock',
            ],
        ]);
    }

    public function apiProductsStore(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'created',
            'message' => 'Product created via Ziggy client!',
            'payload' => $request->all() ?: ['title' => 'Sample Product', 'price' => 99.99],
        ], 201);
    }

    public function apiProductsDestroy($id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => "Product #{$id} deleted successfully via Ziggy HTTP DELETE request.",
        ]);
    }

    public function apiHealthCheck(): JsonResponse
    {
        return response()->json([
            'system' => 'Laravel 12 + Ziggy Route Bridge',
            'status' => 'healthy',
            'latency_ms' => rand(8, 24),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
