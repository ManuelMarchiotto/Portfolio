<x-layout title="Modifica Categoria">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">Indietro</a>
            <h1>Modifica Categoria</h1>

            <x-success />

            <div class="mt-5">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
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