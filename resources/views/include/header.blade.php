<nav class="navbar navbar-dark navbar-expand-lg bg-dark shadow" style="background-color: #ccc;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{{config('app.name')}}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
      </ul>
      <div class="ms-auto">
        @auth
        <a href="{{ route("logout") }}" class="text-white">Logout</a>
        @else
        <a href="{{ route("login") }}" class="text-white">login</a>
        <a href="{{ route("register") }}" class="text-white">register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>