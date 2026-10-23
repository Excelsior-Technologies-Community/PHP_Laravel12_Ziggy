<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Route Architecture Cheat Sheet &amp; Reference Manual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 font-sans antialiased py-8 px-4">

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- Top Actions Bar (Hidden on Print) -->
        <div class="no-print bg-slate-900 text-white px-8 py-4 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-white text-sm font-semibold flex items-center gap-1 transition">
                    <i class="fa-solid fa-arrow-left"></i> Home
                </a>
                <span class="text-slate-600">|</span>
                <a href="{{ route('route.dispatcher') }}" class="text-slate-400 hover:text-white text-sm font-semibold">
                    Live Dispatcher
                </a>
                <span class="text-slate-600">|</span>
                <span class="text-xs bg-blue-500/20 text-blue-400 border border-blue-500/40 px-2 py-0.5 rounded font-mono">
                    LARAVEL 12 &bull; ZIGGY ROUTE MATRIX
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow flex items-center gap-2 transition cursor-pointer">
                    <i class="fa-solid fa-print"></i> Print / Save as PDF
                </button>
            </div>
        </div>

        <!-- Official Cheat Sheet Header -->
        <div class="p-8 sm:p-10 border-b border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2 text-indigo-400 text-xs font-bold uppercase tracking-widest">
                        <i class="fa-solid fa-network-wired"></i> Full Stack Routing Specification
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                        Ziggy Route Architecture Manual
                    </h1>
                    <p class="text-slate-300 mt-2 text-sm max-w-2xl leading-relaxed">
                        Comprehensive developer reference card documenting all named backend routes, parameter signatures, and corresponding client-side JavaScript invocations.
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-xl text-center min-w-[150px]">
                    <div class="text-xs text-indigo-200 uppercase font-bold tracking-wider">Total Named Routes</div>
                    <div class="text-4xl font-black text-emerald-400 my-1">{{ count($routes) }}</div>
                    <div class="text-xs text-slate-300">Ziggy JS Bridge</div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-6 border-t border-slate-700/60 text-xs text-slate-300">
                <div>
                    <span class="text-slate-400 block">Generated:</span>
                    <strong class="text-white">{{ now()->toFormattedDateString() }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Framework:</span>
                    <strong class="text-white">Laravel 12.x + Ziggy 2.x</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Client Helper:</span>
                    <strong class="text-white">window.route(name, params)</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Security Classification:</span>
                    <strong class="text-emerald-400">Public &amp; API Registered</strong>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-8 sm:p-10 space-y-8">

            <!-- KPI Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                    <span class="text-xs text-slate-500 font-semibold uppercase block">Total Named Routes</span>
                    <div class="text-2xl font-black text-blue-600 mt-1">{{ count($routes) }}</div>
                    <span class="text-xs text-slate-500">Accessible in JS</span>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                    <span class="text-xs text-slate-500 font-semibold uppercase block">API Endpoints</span>
                    <div class="text-2xl font-black text-emerald-600 mt-1">{{ $routes->filter(fn($r) => str_starts_with($r['name'], 'api.'))->count() }}</div>
                    <span class="text-xs text-slate-500">JSON REST endpoints</span>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                    <span class="text-xs text-slate-500 font-semibold uppercase block">Parameterized Routes</span>
                    <div class="text-2xl font-black text-indigo-600 mt-1">{{ $routes->filter(fn($r) => count($r['parameters']) > 0)->count() }}</div>
                    <span class="text-xs text-slate-500">Dynamic URL params</span>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                    <span class="text-xs text-slate-500 font-semibold uppercase block">Dev &amp; Testing Tools</span>
                    <div class="text-2xl font-black text-amber-600 mt-1">{{ $routes->filter(fn($r) => str_starts_with($r['name'], 'route.') || $r['name'] === 'favorites')->count() }}</div>
                    <span class="text-xs text-slate-500">Developer suites</span>
                </div>
            </div>

            <!-- Route Directory Table -->
            <div>
                <h2 class="text-lg font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-list text-blue-600"></i> Route Reference Directory
                </h2>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="p-3">HTTP Method</th>
                                <th class="p-3">Route Name</th>
                                <th class="p-3">URI Pattern</th>
                                <th class="p-3">Parameters</th>
                                <th class="p-3">Ziggy Client Invocation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($routes as $route)
                            <tr class="hover:bg-slate-50/70">
                                <td class="p-3">
                                    @php $method = $route['methods'][0] ?? 'GET'; @endphp
                                    <span class="px-2 py-0.5 rounded font-bold text-[11px]
                                        {{ $method === 'GET' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $method === 'POST' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $method === 'DELETE' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ in_array($method, ['PUT', 'PATCH']) ? 'bg-amber-100 text-amber-700' : '' }}
                                    ">
                                        {{ $method }}
                                    </span>
                                </td>
                                <td class="p-3 font-bold font-mono text-slate-800">
                                    {{ $route['name'] }}
                                </td>
                                <td class="p-3 font-mono text-slate-600">
                                    /{{ $route['uri'] }}
                                </td>
                                <td class="p-3 font-mono">
                                    @if(count($route['parameters']) > 0)
                                        <div class="flex gap-1 flex-wrap">
                                            @foreach($route['parameters'] as $param)
                                                <span class="bg-slate-200 text-slate-700 px-1.5 py-0.5 rounded text-[10px]">
                                                    {{ $param }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">none</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <code class="bg-slate-100 text-indigo-700 px-2 py-1 rounded font-mono text-[11px] border border-slate-200">
                                        route('{{ $route['name'] }}'{{ count($route['parameters']) > 0 ? ', { ' . implode(': 1, ', $route['parameters']) . ': 1 }' : '' }})
                                    </code>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer / Developer Notes -->
            <div class="border-t border-slate-200 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-code text-blue-600 text-sm"></i>
                    <span>Generated dynamically by Laravel 12 &bull; tightenco/ziggy Engine</span>
                </div>
                <div>Manual Revision: <strong>ZIGGY-SPEC-2026.1</strong></div>
            </div>

        </div>

    </div>

</body>

</html>
