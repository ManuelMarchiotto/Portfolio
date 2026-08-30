<x-layout title="Eventi">
    <h1>Eventi</h1>

    <div class="mt-5">
        @foreach($events as $index => $event)
            <x-card :category="$event['date']" :title="$event['name']" :route="route('pages.events.show', $index)" />
        @endforeach
    </div>
</x-layout>