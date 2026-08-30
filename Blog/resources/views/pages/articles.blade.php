<x-layout>
    <h1 class="title">Articoli</h1>

    <div class="mt-5">
        @foreach($articles as $article)
            <x-card
                :title="$article->title"
                :category="$article->category"
                :route="route('pages.article', $article)"
            />
        @endforeach
    </div>
</x-layout>