<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-warning" href="{{ route('home') }}">🛒 E-Commerce App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.index') }}">Users</a>
        </li>
      </ul>
      <div class="d-flex gap-2">
        @auth
          <span class="navbar-text text-light me-2">Welcome, {{ Auth::user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm" type="submit">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
          <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>