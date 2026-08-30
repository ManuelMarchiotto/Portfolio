<x-layout :title="$event['name']">
    <div class="mb-1">
        <a href="{{ route('pages.events') }}" class="btn btn-sm btn-secondary">Indietro</a>
    </div>
    
    <h1>{{ $event['name'] }}</h1>
</x-layout>