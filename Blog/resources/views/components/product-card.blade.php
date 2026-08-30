@props([
    'price' => null,
    'name',
    'description',
])

<div class="rounded shadow p-4">
    <h5>{{ $name }}</h5> {{-- Nome prodotto --}}
    <p>{{ $description }}</p>
    
    @if($price)
    <div class="mt-2 text-end">
        <div class="alert alert-success">
            Prezzo: {{ Number::currency($price, in: 'EUR', locale: 'it') }}
        </div>
    </div>
    @endif
</div>