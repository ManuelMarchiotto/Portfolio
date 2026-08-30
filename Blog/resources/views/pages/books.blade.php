<x-layout>
    <h1>Libri</h1>

    <div class="mt-5">
        @foreach($books as $index => $book)
            <x-card
                :title="$book['title']"
                :category="$book['category']"
                :route="route('pages.book', $index)"
            />
        @endforeach
    </div>
</x-layout>