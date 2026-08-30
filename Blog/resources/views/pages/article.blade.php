<x-layout>
    <span>{{ $article->category }}</span>
    <h1>{{ $article->title }}</h1>

    <div class="mt-2 mb-2">
        <span>{{ $article->image }}</span><br>
        <span>{{ Storage::url($article->image) }}</span><br>
        <img class="img-fluid" src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}">
    </div>

    <div class="mt-5">
        {{ $article->body }}
    </div>
</x-layout>