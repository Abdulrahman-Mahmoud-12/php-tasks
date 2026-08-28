<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-warning" href="{{ route('home') }}">🛒 E-Store App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
        </li>

        @if(auth()->user()->role === 'admin')
        <li class="nav-item">
          <a class="nav-link text-warning fw-bold" href="{{ route('categories.index') }}">Categories (Admin)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-warning fw-bold" href="{{ route('users.index') }}">Users (Admin)</a>
        </li>
        @endif
        @endauth
      </ul>

      <div class="d-flex gap-2">
        @auth
          <span class="navbar-text text-light me-2">
            Welcome, {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})
          </span>
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