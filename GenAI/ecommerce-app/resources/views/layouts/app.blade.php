<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NovaMart E-Commerce') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bs-primary: #0d6efd;
            --bs-primary-dark: #0a58ca;
        }
        body { min-height: 100vh; display: flex; flex-direction: column; background-color: #f4f6f9; font-family: system-ui, -apple-system, sans-serif; }
        .wrapper { display: flex; flex: 1; }
        .sidebar { width: 260px; background: #1e293b; min-height: calc(100vh - 60px); color: #94a3b8; transition: all 0.3s; }
        .sidebar .sidebar-title { color: #f8fafc; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.25rem 0.5rem; font-weight: 700; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 0.75rem 1.25rem; display: flex; align-items: center; font-size: 0.925rem; border-left: 3px solid transparent; transition: all 0.2s; }
        .sidebar a:hover { color: #f8fafc; background: #334155; border-left-color: #38bdf8; }
        .sidebar a.active { color: #ffffff; background: #0f172a; border-left-color: #0d6efd; font-weight: 600; }
        .content { flex: 1; padding: 2rem; }
        .navbar-custom { background-color: #0f172a !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .nav-link-custom { color: #cbd5e1 !important; font-weight: 500; padding: 0.5rem 1rem !important; border-radius: 0.375rem; transition: all 0.2s; }
        .nav-link-custom:hover, .nav-link-custom.active { color: #ffffff !important; background-color: rgba(255,255,255,0.1); }
        .stat-card { border: none; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
    </style>
</head>
<body>

    <!-- Main Global Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-white fs-4 d-flex align-items-center me-4" href="{{ url('/') }}">
                <i class="bi bi-bag-heart-fill text-primary me-2 fs-3"></i>
                <span>Nova<span class="text-primary">Mart</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-grid me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags me-1"></i> Categories
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                <i class="bi bi-receipt me-1"></i> Orders
                            </a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('chatbot*') ? 'active' : '' }}" href="{{ route('chatbot.index') }}">
                            <i class="bi bi-robot me-1 text-info"></i> AI Assistant
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item dropdown ms-lg-2">
                                <a class="nav-link nav-link-custom dropdown-toggle text-warning border border-warning-subtle px-3" href="#" id="adminDropdown" data-bs-toggle="dropdown">
                                    <i class="bi bi-speedometer2 me-1"></i> Admin Console
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark shadow-lg">
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-columns-gap me-2 text-primary"></i>Main Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard.categories') }}"><i class="bi bi-pie-chart-fill me-2 text-info"></i>Categories Insights</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard.orders') }}"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Orders Insights</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('users.index') }}"><i class="bi bi-people me-2 text-warning"></i>Manage Users</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    @guest
                        <li class="nav-item"><a class="btn btn-outline-light btn-sm px-3" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i> Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="badge bg-secondary ms-2 text-uppercase" style="font-size: 0.65rem;">{{ Auth::user()->role }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <div class="text-muted small">{{ Auth::user()->email }}</div>
                                </li>
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger py-2" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Wrapper -->
    <div class="wrapper">
        @auth
            @if(Auth::user()->isAdmin() && request()->is('admin*'))
                <div class="sidebar d-none d-md-block">
                    <div class="sidebar-title">Main Menu</div>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i>Overview</a>
                    
                    <div class="sidebar-title mt-2">Secondary Dashboards</div>
                    <a href="{{ route('admin.dashboard.categories') }}" class="{{ request()->routeIs('admin.dashboard.categories') ? 'active' : '' }}"><i class="bi bi-tags-fill me-2 text-info"></i>Categories Insights</a>
                    <a href="{{ route('admin.dashboard.orders') }}" class="{{ request()->routeIs('admin.dashboard.orders') ? 'active' : '' }}"><i class="bi bi-graph-up me-2 text-success"></i>Orders Insights</a>
                    
                    <div class="sidebar-title mt-2">Resource Management</div>
                    <a href="{{ route('categories.index') }}" class="{{ request()->is('categories*') ? 'active' : '' }}"><i class="bi bi-folder me-2"></i>Categories</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}"><i class="bi bi-box-seam me-2"></i>Products</a>
                    <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i>Users</a>
                    <a href="{{ route('orders.index') }}" class="{{ request()->is('orders*') ? 'active' : '' }}"><i class="bi bi-cart-check me-2"></i>Orders</a>
                </div>
            @endif
        @endauth

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Floating Chatbot Widget Button -->
    <button id="chat-toggle-btn" class="btn btn-primary rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4 p-3 d-flex align-items-center justify-content-center" style="z-index: 1050; width: 60px; height: 60px;">
        <i class="bi bi-robot fs-3 text-white"></i>
    </button>

    <!-- Floating Chat Window Modal -->
    <div id="chat-modal" class="card position-fixed bottom-0 end-0 m-4 d-none shadow-lg border-0" style="z-index: 1060; width: 380px; height: 500px; border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-slate-900 bg-dark text-white d-flex justify-content-between align-items-center py-3 px-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                    <i class="bi bi-robot fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">NovaMart AI Assistant</h6>
                    <small class="text-success fs-7"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Online</small>
                </div>
            </div>
            <button id="chat-close-btn" class="btn-close btn-close-white btn-sm"></button>
        </div>
        <div id="chat-messages" class="card-body overflow-auto p-3 bg-light" style="height: 380px;">
            <div class="bg-white p-3 rounded-3 shadow-sm mb-3 text-dark small border" style="max-width: 85%;">
                Hello! 👋 I am your AI assistant. Ask me anything about our categories, products, or store metrics!
            </div>
        </div>
        <div class="card-footer bg-white p-2 border-top">
            <form id="chat-form" class="d-flex align-items-center">
                <input type="text" id="chat-input" class="form-control form-control-sm me-2 rounded-pill px-3" placeholder="Ask AI assistant..." required>
                <button type="submit" class="btn btn-primary btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;"><i class="bi bi-send-fill fs-6"></i></button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('chat-toggle-btn');
            const closeBtn = document.getElementById('chat-close-btn');
            const chatModal = document.getElementById('chat-modal');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            if (toggleBtn && chatModal) {
                toggleBtn.addEventListener('click', () => chatModal.classList.toggle('d-none'));
                closeBtn.addEventListener('click', () => chatModal.classList.add('d-none'));
            }

            if (chatForm) {
                chatForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const message = chatInput.value.trim();
                    if (!message) return;

                    chatMessages.innerHTML += `
                        <div class="bg-primary text-white p-3 rounded-3 shadow-sm mb-3 ms-auto small text-end" style="max-width: 85%;">
                            ${escapeHtml(message)}
                        </div>`;
                    chatInput.value = '';
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    const loadingId = 'loading-' + Date.now();
                    chatMessages.innerHTML += `
                        <div id="${loadingId}" class="bg-white p-3 rounded-3 shadow-sm mb-3 text-muted small border" style="max-width: 85%;">
                            <span class="spinner-border spinner-border-sm text-primary me-2"></span> Thinking...
                        </div>`;
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    try {
                        const response = await fetch("{{ route('chat.ask') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ message: message })
                        });

                        const data = await response.json();
                        document.getElementById(loadingId).remove();

                        chatMessages.innerHTML += `
                            <div class="bg-white p-3 rounded-3 shadow-sm mb-3 text-dark small border" style="max-width: 85%;">
                                ${escapeHtml(data.reply || 'No response returned.')}
                            </div>`;
                    } catch (error) {
                        if (document.getElementById(loadingId)) {
                            document.getElementById(loadingId).remove();
                        }
                        chatMessages.innerHTML += `
                            <div class="bg-danger text-white p-3 rounded-3 shadow-sm mb-3 small" style="max-width: 85%;">
                                Error connecting to assistant.
                            </div>`;
                    }
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });
            }

            function escapeHtml(text) {
                return text.replace(/[&<>"']/g, function(m) {
                    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>