<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Il tuo carrello UrbanWear.">
    <title>Carrello — UrbanWear</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0a0a0a] font-sans text-zinc-100 antialiased">
    <div class="border-b border-white/10 bg-[#b6ff33] px-4 py-2 text-center text-[10px] font-black tracking-[0.2em] text-black sm:text-xs">SPEDIZIONE GRATUITA IN ITALIA SOPRA I 100 €</div>
    <header class="border-b border-white/10 bg-[#0a0a0a]/90 backdrop-blur"><nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8"><a href="{{ route('home') }}" class="text-xl font-black tracking-[-0.08em] text-white sm:text-2xl">URBAN<span class="text-[#b6ff33]">WEAR</span></a><div class="hidden items-center gap-8 text-xs font-bold uppercase tracking-[0.16em] text-zinc-300 lg:flex"><a class="transition hover:text-[#b6ff33]" href="{{ route('home') }}#drop">Nuovi arrivi</a><a class="transition hover:text-[#b6ff33]" href="{{ route('catalog.index') }}">Shop</a><a class="transition hover:text-[#b6ff33]" href="{{ route('home') }}#story">Manifesto</a></div><a class="relative text-[#b6ff33]" href="{{ route('cart.index') }}" aria-label="Apri il carrello"><svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.4 12.1a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg><span class="absolute -right-2 -top-2 grid size-4 place-items-center rounded-full bg-[#b6ff33] text-[9px] font-black text-black">{{ $items->sum('quantity') }}</span></a></nav></header>
    <main class="mx-auto max-w-7xl px-5 py-12 lg:px-8 lg:py-16">
        <p class="text-[10px] font-black uppercase tracking-[0.24em] text-[#b6ff33]">UrbanWear / Bag</p><h1 class="mt-3 text-5xl font-black tracking-[-0.07em] text-white sm:text-7xl">IL TUO CARRELLO.</h1>
        @if (session('success'))<div class="mt-8 border border-[#b6ff33]/40 bg-[#b6ff33]/10 px-4 py-3 text-sm text-[#d5ff8c]" role="status">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="mt-8 border border-red-400/40 bg-red-400/10 px-4 py-3 text-sm text-red-200" role="alert">{{ session('error') }}</div>@endif
        @if ($items->isNotEmpty())
            <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_360px]">
                <section class="divide-y divide-white/10 border-y border-white/10">
                    @foreach ($items as $key => $item)
                        <article class="flex gap-4 py-5 sm:gap-6 sm:py-6">
                            <div class="relative size-24 shrink-0 overflow-hidden bg-zinc-800 sm:size-32"><div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(182,255,51,0.2),transparent_62%)]"></div><div class="absolute bottom-0 left-1/2 h-[65%] w-[55%] -translate-x-1/2 rounded-t-[45%] bg-zinc-950"></div></div>
                            <div class="flex min-w-0 flex-1 flex-col"><div class="flex items-start justify-between gap-3"><div><p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Taglia {{ $item['size'] ?? 'Unica' }}</p><h2 class="mt-1 font-bold text-white">{{ $item['name'] }}</h2></div><p class="shrink-0 text-sm font-bold text-[#b6ff33]">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} €</p></div><div class="mt-auto flex items-end justify-between gap-4 pt-4"><form action="{{ route('cart.update', $key) }}" method="POST">@csrf @method('PATCH')<label class="text-[10px] font-black uppercase tracking-[0.14em] text-zinc-500" for="quantity-{{ $loop->index }}">Quantità</label><div class="mt-2 flex"><input id="quantity-{{ $loop->index }}" class="w-16 border border-white/20 bg-transparent px-2 py-2 text-center text-sm focus:border-[#b6ff33] focus:outline-none" name="quantity" type="number" min="0" value="{{ $item['quantity'] }}"><button class="border border-l-0 border-white/20 px-3 text-[10px] font-black uppercase tracking-wider text-zinc-300 transition hover:border-[#b6ff33] hover:text-[#b6ff33]" type="submit">Aggiorna</button></div></form><form action="{{ route('cart.destroy', $key) }}" method="POST">@csrf @method('DELETE')<button class="text-[10px] font-black uppercase tracking-[0.14em] text-zinc-500 transition hover:text-red-400" type="submit">Rimuovi</button></form></div></div>
                        </article>
                    @endforeach
                </section>
                <aside class="h-fit border border-white/15 bg-[#101010] p-6 lg:sticky lg:top-6"><h2 class="text-xl font-black tracking-[-0.04em] text-white">RIEPILOGO ORDINE</h2><div class="mt-6 space-y-3 border-b border-white/10 pb-5 text-sm text-zinc-400"><div class="flex justify-between"><span>Subtotale</span><span>{{ number_format($total, 0, ',', '.') }} €</span></div><div class="flex justify-between"><span>Spedizione</span><span class="text-[#b6ff33]">Gratuita</span></div></div><div class="mt-5 flex items-end justify-between"><span class="text-xs font-black uppercase tracking-[0.14em] text-white">Totale</span><span class="text-2xl font-black text-[#b6ff33]">{{ number_format($total, 0, ',', '.') }} €</span></div><a class="mt-7 block w-full bg-[#b6ff33] px-4 py-4 text-center text-xs font-black uppercase tracking-[0.14em] text-black transition hover:bg-white" href="{{ route('checkout.create') }}">Vai al checkout</a><a class="mt-5 block text-center text-[10px] font-bold uppercase tracking-[0.14em] text-zinc-400 hover:text-white" href="{{ route('catalog.index') }}">← Continua lo shopping</a></aside>
            </div>
        @else
            <section class="mt-10 border border-dashed border-white/20 px-6 py-20 text-center"><p class="text-lg font-black text-white">IL CARRELLO È VUOTO.</p><p class="mt-2 text-sm text-zinc-400">Scegli un capo dal catalogo e rendilo tuo.</p><a class="mt-7 inline-block bg-[#b6ff33] px-6 py-4 text-xs font-black uppercase tracking-[0.14em] text-black transition hover:bg-white" href="{{ route('catalog.index') }}">Esplora il catalogo →</a></section>
        @endif
    </main>
</body>
</html>
