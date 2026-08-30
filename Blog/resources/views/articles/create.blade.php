<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Crea Nuovo Articolo</h4>
                    </div>
                    <div class="card-body">

                        {{-- Esercizio 4: Messaggio esito positivo --}}
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Form con enctype per l'upload di file (Esercizio 6.b) --}}
                        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Titolo -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Titolo</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Categoria -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoria</label>
                                <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}">
                                @error('category')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Testo / Body -->
                            <div class="mb-3">
                                <label for="body" class="form-label">Contenuto</label>
                                <textarea name="body" id="body" rows="5" class="form-control">{{ old('body') }}</textarea>
                                @error('body')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Immagine (Esercizio 6.b) -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Immagine Copertina</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Salva Articolo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
