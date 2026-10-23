import './bootstrap';
import { route as ziggyRoute } from 'ziggy-js';
import { Ziggy as staticZiggy } from './ziggy';

// Dynamically compute the active Ziggy configuration
// Adapts automatically whether served via `php artisan serve` (port 8000/custom)
// or Apache/XAMPP subfolders (e.g. /git_desktop/PHP_Laravel12_Ziggy/public)
export function getActiveZiggy() {
    let config = Object.assign({}, staticZiggy);

    // 1. If server rendered window.Ziggy via @routes, merge it
    if (typeof window !== 'undefined' && window.Ziggy) {
        config = Object.assign({}, config, window.Ziggy);
        if (window.Ziggy.routes) {
            config.routes = Object.assign({}, staticZiggy.routes || {}, window.Ziggy.routes);
        }
    }

    // 2. Auto-detect browser environment origin and subfolder (XAMPP / WAMP)
    if (typeof window !== 'undefined' && window.location) {
        const loc = window.location;
        const origin = loc.origin; // e.g. "http://localhost:8000" or "http://localhost"
        const pathname = loc.pathname;

        // Check if running inside a subfolder (e.g. XAMPP htdocs)
        const publicMatch = pathname.match(/^(.*\/public)/);
        const folderMatch = pathname.match(/^(.*\/PHP_Laravel12_Ziggy(\/public)?)/);

        if (publicMatch) {
            config.url = origin + publicMatch[1];
        } else if (folderMatch) {
            config.url = origin + folderMatch[1];
        } else if (loc.port && loc.port !== '80' && loc.port !== '443') {
            config.url = origin;
            config.port = parseInt(loc.port, 10);
        } else if (origin && origin !== 'null') {
            config.url = origin;
            config.port = null;
        }
    }

    if (typeof window !== 'undefined') {
        window.Ziggy = config;
    }
    return config;
}

// Client-Side Route Telemetry Store
window.recordRouteTelemetry = (name, params, executionTimeMs) => {
    try {
        const stored = JSON.parse(localStorage.getItem('ziggy_telemetry') || '[]');
        stored.push({
            name: name,
            params: params,
            time: new Date().toISOString(),
            latency_ms: executionTimeMs,
        });
        if (stored.length > 150) stored.shift();
        localStorage.setItem('ziggy_telemetry', JSON.stringify(stored));

        // Dispatch a custom event so live telemetry dashboards can listen
        window.dispatchEvent(new CustomEvent('ziggy:route_called', {
            detail: { name, params, latency_ms: executionTimeMs }
        }));
    } catch (e) {}
};

// Make route() function globally available with telemetry instrumentation
window.route = (name, params = {}, absolute = true, customZiggy = null) => {
    const config = customZiggy || getActiveZiggy();
    const start = performance.now();
    const result = ziggyRoute(name, params, absolute, config);
    const duration = Math.round((performance.now() - start) * 100) / 100;
    if (name) {
        window.recordRouteTelemetry(name, params, duration);
    }
    return result;
};

// Initialize immediately in browser
if (typeof window !== 'undefined') {
    getActiveZiggy();
}
