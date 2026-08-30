<x-layout title="Gestione Categorie">
    <div class="row">
        <div class="col-lg-6">
        <h1>Gestione Categorie</h1>
        </div>
        <div class="col-lg-6 text-end">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Crea</a>
        </div>
    </div>

    <x-success />

    <div class="mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-end">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-secondary">modifica</a>
                        <form class="d-inline ms-1" action="{{ route('categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">elimina</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
</x-layout>