<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>I miei ordini — UrbanWear</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="min-h-screen bg-[#0a0a0a] font-sans text-zinc-100 antialiased"><header class="border-b border-white/10"><nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8"><a href="{{ route('home') }}" class="text-xl font-black tracking-[-0.08em] text-white sm:text-2xl">URBAN<span class="text-[#b6ff33]">WEAR</span></a><form method="POST" action="{{ route('logout') }}">@csrf<button class="text-xs font-bold uppercase tracking-[0.14em] text-zinc-400 hover:text-white" type="submit">Esci</button></form></nav></header><main class="mx-auto max-w-5xl px-5 py-12 lg:px-8 lg:py-16"><p class="text-[10px] font-black uppercase tracking-[0.24em] text-[#b6ff33]">Area personale / {{ auth()->user()->name }}</p><h1 class="mt-3 text-5xl font-black tracking-[-0.07em] text-white sm:text-7xl">I MIEI ORDINI.</h1>
@if (session('success'))
<div class="mt-8 border border-[#b6ff33]/40 bg-[#b6ff33]/10 px-4 py-3 text-sm text-[#d5ff8c]">{{ session('success') }}</div>
@endif
@if ($orders->isEmpty())
<div class="mt-10 border border-dashed border-white/20 px-6 py-16 text-center"><p class="font-black text-white">NESSUN ORDINE.</p><a class="mt-6 inline-block bg-[#b6ff33] px-6 py-4 text-xs font-black uppercase tracking-[0.14em] text-black" href="{{ route('catalog.index') }}">Esplora il catalogo</a></div>
@else
<div class="mt-10 space-y-4">@foreach ($orders as $order)<article class="border border-white/15 bg-[#101010] p-6"><div class="flex flex-wrap items-start justify-between gap-4"><div><p class="text-xs font-black uppercase tracking-wider text-white">Ordine #{{ $order->id }}</p><p class="mt-1 text-xs text-zinc-500">{{ $order->created_at->format('d/m/Y') }} · {{ ucfirst($order->status) }}</p></div><p class="text-xl font-black text-[#b6ff33]">{{ number_format($order->total, 0, ',', '.') }} €</p></div><div class="mt-5 border-t border-white/10 pt-4 text-sm text-zinc-400">@foreach ($order->items as $item)<p>{{ $item->product_name }} × {{ $item->quantity }}{{ $item->size ? ' · Taglia '.$item->size : '' }}</p>@endforeach</div></article>@endforeach</div>
@endif
</main></body>
</html>
