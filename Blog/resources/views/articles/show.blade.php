<x-layout>
    <div class="container">
        <h1>{{ $article->title }}</h1>
        <p class="text-muted">Categoria: {{ $article->category }}</p>

        @if($article->image_path)
            <div class="mb-4">
                <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="img-fluid rounded max-w-lg">
            </div>
        @endif

        <div class="content">
            <p>{{ $article->body }}</p>
        </div>
    </div>
</x-layout>
