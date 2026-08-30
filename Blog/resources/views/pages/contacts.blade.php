<x-layout title="Contatti">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h1>Contatti</h1>
            <p class="lead text-muted">Indicazioni per compilare il form...</p>
            <p class="small text-muted">I campi indicati con (*) sono obbligatori.</p>

            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="mt-5">
                <form action="{{ route('pages.contacts.send') }}" method="POST">
                    @csrf 
                    <div class="row g-3">
                        @guest
                        <div class="col-12">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                maxlength="100" required
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                maxlength="255" required
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        @else
                        <p class="lead">Ciao {{ auth()->user()->name }}! Dicci di cosa hai bisogno.</p>
                        @endguest
                        <div class="col-12">
                            <label for="message">Messaggio</label>
                            <textarea name="message" id="message" maxlength="500" required
                                class="form-control @error('message') is-invalid @enderror" rows="6">{{ old('message') }}</textarea>
                            @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Invia Messaggio</button>
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </div>
</x-layout>