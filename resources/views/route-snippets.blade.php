<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Multi-Framework Code Snippet Studio</title>

    @routes
    @vite('resources/js/app.js')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        body {
            background: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-dark {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .code-box {
            background: #020617;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #38bdf8;
            font-family: 'Consolas', 'Courier New', monospace;
            padding: 16px;
            font-size: 13px;
            white-space: pre-wrap;
            position: relative;
        }

        .nav-pills .nav-link {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 16px;
        }

        .nav-pills .nav-link.active {
            background: #2563eb;
            color: white;
        }

        .form-control, .form-select {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            background-color: #0f172a;
            border-color: #38bdf8;
            color: #f8fafc;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Top Navigation Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-50">
                        🔄 MULTI-FRAMEWORK STUDIO
                    </span>
                    <span class="badge bg-secondary">React &bull; Vue 3 &bull; Inertia &bull; Alpine &bull; Axios</span>
                </div>
                <h3 class="fw-bold mb-0 text-white">
                    <i class="fa-solid fa-code text-info me-2"></i> Multi-Framework Code Snippet Studio
                </h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-home me-1"></i> Home
                </a>
                <a href="{{ route('route.dispatcher') }}" class="btn btn-outline-info btn-sm">
                    <i class="fa-solid fa-paper-plane me-1"></i> Request Dispatcher
                </a>
                <a href="{{ route('route.tree') }}" class="btn btn-outline-warning btn-sm">
                    <i class="fa-solid fa-sitemap me-1"></i> Route Tree
                </a>
                <a href="{{ route('route.telemetry') }}" class="btn btn-outline-success btn-sm">
                    <i class="fa-solid fa-chart-line me-1"></i> Telemetry Radar
                </a>
                <a href="{{ route('route.cheatsheet') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-file-pdf me-1"></i> Cheat Sheet
                </a>
            </div>
        </div>

        {{-- Route Configuration Bar --}}
        <div class="card card-dark p-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-slate-300">Choose Laravel Route</label>
                    <select id="routeSelect" class="form-select" onchange="onRouteSelected()">
                        <!-- Dynamic options -->
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label small fw-bold text-slate-300">Target Parameters</label>
                    <div id="paramsInputContainer" class="d-flex gap-2 flex-wrap">
                        <!-- Dynamic param inputs -->
                    </div>
                </div>
            </div>
        </div>

        {{-- Code Snippets Tabs Card --}}
        <div class="card card-dark p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <ul class="nav nav-pills" id="frameworkTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="tab-react" data-bs-toggle="pill" data-bs-target="#pane-react">
                            <i class="fa-brands fa-react text-info me-1"></i> React.js
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-vue" data-bs-toggle="pill" data-bs-target="#pane-vue">
                            <i class="fa-brands fa-vuejs text-success me-1"></i> Vue 3 Composition
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-inertia" data-bs-toggle="pill" data-bs-target="#pane-inertia">
                            <i class="fa-solid fa-arrows-split-up-and-left text-purple-400 me-1"></i> Inertia.js
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-axios" data-bs-toggle="pill" data-bs-target="#pane-axios">
                            <i class="fa-solid fa-satellite-dish text-primary me-1"></i> Axios Client
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-alpine" data-bs-toggle="pill" data-bs-target="#pane-alpine">
                            <i class="fa-solid fa-mountain text-warning me-1"></i> Alpine.js
                        </button>
                    </li>
                </ul>

                <button class="btn btn-outline-info btn-sm" onclick="copyCurrentSnippet()">
                    <i class="fa-solid fa-copy me-1"></i> Copy Active Snippet
                </button>
            </div>

            <div class="tab-content" id="frameworkTabsContent">
                {{-- React Pane --}}
                <div class="tab-pane fade show active" id="pane-react">
                    <pre class="code-box" id="snippetReact"></pre>
                </div>

                {{-- Vue Pane --}}
                <div class="tab-pane fade" id="pane-vue">
                    <pre class="code-box" id="snippetVue"></pre>
                </div>

                {{-- Inertia Pane --}}
                <div class="tab-pane fade" id="pane-inertia">
                    <pre class="code-box" id="snippetInertia"></pre>
                </div>

                {{-- Axios Pane --}}
                <div class="tab-pane fade" id="pane-axios">
                    <pre class="code-box" id="snippetAxios"></pre>
                </div>

                {{-- Alpine Pane --}}
                <div class="tab-pane fade" id="pane-alpine">
                    <pre class="code-box" id="snippetAlpine"></pre>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentRouteName = 'user.profile';
        let currentParams = {};

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('routeSelect');
            select.innerHTML = '';

            const routes = window.Ziggy && window.Ziggy.routes ? window.Ziggy.routes : {};
            const names = Object.keys(routes).sort();

            names.forEach(name => {
                const opt = document.createElement('option');
                opt.value = name;
                opt.textContent = `${name} (${routes[name].uri})`;
                select.appendChild(opt);
            });

            if (select.querySelector('option[value="post.details"]')) {
                select.value = 'post.details';
            } else if (names.length > 0) {
                select.value = names[0];
            }

            onRouteSelected();
        });

        function onRouteSelected() {
            currentRouteName = document.getElementById('routeSelect').value;
            const routeDef = window.Ziggy.routes[currentRouteName];
            if (!routeDef) return;

            const paramMatches = routeDef.uri.match(/\{([^}]+)\}/g) || [];
            const container = document.getElementById('paramsInputContainer');
            container.innerHTML = '';
            currentParams = {};

            if (paramMatches.length === 0) {
                container.innerHTML = '<span class="text-secondary small italic pt-2">No parameters required for this route.</span>';
            } else {
                paramMatches.forEach(p => {
                    const raw = p.replace(/[\{\}\?]/g, '');
                    currentParams[raw] = raw === 'id' ? '42' : (raw === 'category' ? 'tech' : (raw === 'slug' ? 'laravel-12-ziggy' : 'demo'));

                    const div = document.createElement('div');
                    div.style.minWidth = '140px';
                    div.innerHTML = `
                        <input type="text" class="form-control form-control-sm" placeholder="${raw}" value="${currentParams[raw]}" oninput="onParamChange('${raw}', this.value)">
                    `;
                    container.appendChild(div);
                });
            }

            generateSnippets();
        }

        function onParamChange(key, val) {
            currentParams[key] = val;
            generateSnippets();
        }

        function generateSnippets() {
            const hasParams = Object.keys(currentParams).length > 0;
            const paramJson = hasParams ? JSON.stringify(currentParams, null, 2).replace(/\n/g, '\n  ') : '';
            const paramInline = hasParams ? JSON.stringify(currentParams) : '';

            // 1. React Snippet
            document.getElementById('snippetReact').textContent = `// React JSX Component Example
import React from 'react';
import { route } from 'ziggy-js';
import { Ziggy } from './ziggy';

export default function ActionButton() {
  const targetUrl = route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''});

  return (
    <a 
      href={targetUrl} 
      className="btn btn-primary"
      onClick={(e) => {
        // e.preventDefault();
        console.log("Navigating to: " + targetUrl);
      }}
    >
      Navigate to ${currentRouteName}
    </a>
  );
}`;

            // 2. Vue 3 Snippet
            document.getElementById('snippetVue').textContent = `<!-- Vue 3 Composition API Component (<script setup>) -->
<script setup>
import { route } from 'ziggy-js';
import { Ziggy } from '@/ziggy';

const handleNavigation = () => {
  const url = route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''});
  window.location.href = url;
};
<\/script>

<template>
  <button @click="handleNavigation" class="btn-primary">
    Open @{{ url }}
  </button>
</template>`;

            // 3. Inertia Snippet
            document.getElementById('snippetInertia').textContent = `// Inertia.js (React / Vue / Svelte Adapter)
import { router, Link } from '@inertiajs/react';

// 1. Declarative Link component:
<Link href={route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''})}>
  View ${currentRouteName}
</Link>

// 2. Programmatic router visit:
function triggerInertiaVisit() {
  router.visit(route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''}), {
    method: 'get',
    preserveScroll: true,
    onSuccess: () => console.log('Page loaded!'),
  });
}`;

            // 4. Axios Snippet
            document.getElementById('snippetAxios').textContent = `// Axios HTTP API Integration with Ziggy
import axios from 'axios';
import { route } from 'ziggy-js';

async function fetchRouteData() {
  try {
    const endpoint = route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''});
    
    const response = await axios.get(endpoint, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    console.log('Response Payload:', response.data);
    return response.data;
  } catch (error) {
    console.error('Request failed:', error.response?.data || error.message);
  }
}`;

            // 5. Alpine.js Snippet
            document.getElementById('snippetAlpine').textContent = `<!-- Alpine.js Inline Reactive Component -->
<div 
  x-data="{ 
    url: route('${currentRouteName}'${hasParams ? ', ' + paramInline : ''}) 
  }"
>
  <a :href="url" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">
    Visit with Alpine: <span x-text="url"></span>
  </a>
</div>`;
        }

        function copyCurrentSnippet() {
            const activeTab = document.querySelector('.tab-pane.active pre');
            if (activeTab) {
                navigator.clipboard.writeText(activeTab.textContent);
                alert('Code snippet copied to clipboard!');
            }
        }
    </script>

</body>

</html>
