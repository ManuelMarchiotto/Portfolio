<x-layout title="Modifica articolo">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div>
                <a href="{{ route('account.articles') }}" class="btn btn-secondary btn-sm">indietro</a>
                <h1>Modifica articolo</h1>

                <x-success />

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                        @endforeach
                    </div>
                @endif

                {{-- Form modifica articolo --}}
                <form action="{{ route('account.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title">Titolo *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label for="category">Categoria *</label>                            
                            <select name="category" id="category" class="form-control">
                                @foreach($categories as $category)
                                    <option @selected($category->name === old('category', $article->category)) value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label for="image">Immagine</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="body">Corpo</label>
                            <textarea name="body" id="body" class="form-control" rows="10">{{ old('title', $article->body) }}</textarea>
                            @error('body') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 small text-muted">
                            I campi contrassegnati da (*) sono obbligatori.
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Modifica</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

