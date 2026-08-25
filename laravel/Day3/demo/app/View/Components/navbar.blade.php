<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">E-Store</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('users.index') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('categories.index') }}">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('products.index') }}">Products</a>
        </li>
      </ul>
      <div class="d-flex gap-2">
        @auth
          <span class="navbar-text me-2">Hello, {{ Auth::user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger" type="submit">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
          <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>