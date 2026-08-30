<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @foreach($links as $link)
        <li class="nav-item">
          <a class="nav-link @if($link['active']) active text-primary @endif" href="{{ $link['link'] }}">{{ $link['label'] }}</a>
        </li>
        @endforeach
      </ul>

      @auth
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->email }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('account.articles') }}">Gestione Articoli</a></li>
            <li><a class="dropdown-item" href="{{ route('categories.index') }}">Gestione Categorie</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="/logout" method="POST">
                  @csrf
                  <button class="dropdown-item">Esci</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
      @else
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/login">Accedi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Registrati</a>
        </li>
      </ul>
      @endauth
    </div>
  </div>
</nav>