<x-layout title="Benvenuto">
    @auth {{-- if sei autenticato --}}
        <h1>Benvenuto {{ auth()->user()->email }}</h1>

        <div class="mt-2">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Esci</button>
            </form>
        </div>
    @else {{-- else è opzionale --}}
        <h1>Non sei autenticato</h1>
    @endauth


    @guest {{-- if non sei autenticato --}}
        Non autenticato
    @else {{-- else è opzionale --}}
        Sei autenticato
    @endguest

    @auth
        Sei autenticato
    @endauth
</x-layout>

