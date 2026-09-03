<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="#">TESTE</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('catalogouser')}}">Catálogo</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('planos')}}">Planos</a> 
        </li>
        <li class="nav-item">  
          <a class="nav-link" href="{{ url('avaliacao')}}">Avaliação</a> 
        </li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
    @csrf

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); this.closest('form').submit();"
       class="text-sm text-gray-700 underline hover:text-gray-900">
        Sair (Logout)
    </a>
</form>
        </li>
      </ul>
    </div>
  </div>
</nav>
