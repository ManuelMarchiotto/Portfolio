<x-layout title="Crea nuovo articolo">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div>
                <a href="{{ route('account.articles') }}" class="btn btn-secondary btn-sm">indietro</a>
                <h1>Crea nuovo articolo</h1>

                <x-success />

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                        @endforeach
                    </div>
                @endif

                {{-- Form creazione articolo --}}
                <form action="{{ route('account.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title">Titolo *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label for="category">Categoria *</label>
                            <select name="category" id="category" class="form-control">
                                @foreach($categories as $category)
                                    <option @selected($category->name === old('category')) value="{{ $category->name }}">{{ $category->name }}</option>
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
                            <textarea name="body" id="body" class="form-control" rows="10">{{ old('body') }}</textarea>
                            @error('body') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 small text-muted">
                            I campi contrassegnati da (*) sono obbligatori.
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Crea</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

