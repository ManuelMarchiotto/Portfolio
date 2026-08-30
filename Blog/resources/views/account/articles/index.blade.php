<x-layout title="Gestione Articoli">
    <div class="row">
        <div class="col-lg-6">
            <h1>Gestione Articoli</h1>
        </div>
        <div class="col-lg-6 text-end">
            <a href="{{ route('account.articles.create') }}" class="btn btn-primary">Crea</a>
        </div>
    </div>

    <x-success />

    <div class="mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titolo</th>
                    <th>Categoria</th>
                    <th>Visibile</th>
                    <th>Data Creazione</th>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category }}</td>
                    <td>{{ $article->visible }}</td>
                    <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('account.articles.edit', $article) }}" class="btn btn-sm btn-secondary">modifica</a>
                        <form class="d-inline ms-1" action="{{ route('account.articles.destroy', $article) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">elimina</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- $articles->links() --}}
    </div>
</x-layout>