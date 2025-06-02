<nav class="navbar navbar-dark navbar-expand-lg bg-dark shadow" style="background-color: #ccc;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{{config('app.name')}}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route("movie.list") }}">List</a>
        </li>
      </ul>

      <!-- <div class="ms-auto">
        @auth
        <a href="{{ route("logout") }}" class="auth-link">Logout</a>
        @else
        <a href="{{ route("login") }}" class="auth-link">login</a>
        <a href="{{ route("register") }}" class="auth-link">register</a>
        @endauth
      </div>   -->

      <div class="ms-auto">
        <form action="{{ route('movie.list') }}" method="GET" class="d-flex">
          <input type="text" name="title" class="form-control me-2 bg-dark text-white placeholder-light border-secondary"
            placeholder="Enter movie title" value="{{ request('title') }}">
          <button class="btn btn-danger me-5" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>