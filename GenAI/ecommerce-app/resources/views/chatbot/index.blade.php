@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 900px;">
    <!-- Page Title & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-robot text-primary me-2"></i>AI Assistant Hub
            </h2>
            <p class="text-muted small mb-0">
                Interactive AI Assistant powered by Google Gemini 2.5 Flash.
            </p>
        </div>
        <div>
            <span class="badge {{ Auth::check() && Auth::user()->isAdmin() ? 'bg-warning text-dark' : 'bg-info text-white' }} px-3 py-2 rounded-pill fs-7 fw-bold">
                <i class="bi {{ Auth::check() && Auth::user()->isAdmin() ? 'bi-shield-lock-fill' : 'bi-person-check-fill' }} me-1"></i>
                {{ Auth::check() && Auth::user()->isAdmin() ? 'Admin Insights Mode' : 'Customer Shopping Mode' }}
            </span>
        </div>
    </div>

    <!-- Chat Card Container -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-dark text-white p-3 p-lg-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi bi-robot fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white">NovaMart AI Assistant</h5>
                    <small class="text-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Active & Ready</small>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="clearChatHistory()">
                <i class="bi bi-trash me-1"></i> Clear Chat
            </button>
        </div>

        <!-- Chat Output Messages Container -->
        <div id="full-chat-messages" class="card-body p-4 bg-light overflow-auto" style="height: 440px;">
            <div class="bg-white p-3 rounded-4 shadow-sm mb-3 text-dark border d-flex gap-3 align-items-start" style="max-width: 85%;">
                <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <div class="fw-semibold text-primary mb-1">NovaMart AI</div>
                    <div>
                        Hello! I am your store AI Assistant. 
                        @if(Auth::check() && Auth::user()->isAdmin())
                            You are logged in as <strong>Admin</strong>. You can ask me for business metrics, product inventory stock health, revenue totals, or sales distribution.
                        @else
                            Ask me questions about available product categories, item prices, descriptions, or store guidance!
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Suggestion Pills -->
        <div class="px-4 py-2 bg-white border-top border-bottom">
            <small class="text-muted fw-bold d-block mb-2"><i class="bi bi-lightbulb text-warning me-1"></i> Suggested Prompts:</small>
            <div class="d-flex flex-wrap gap-2">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">What is our total revenue and order count?</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">Which categories have the most products?</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">Are there any low-stock items?</button>
                @else
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">What categories do you offer?</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">Can you recommend popular products?</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill pill-prompt" onclick="usePrompt(this)">How can I place an order?</button>
                @endif
            </div>
        </div>

        <!-- Input Form -->
        <div class="card-footer bg-white p-3">
            <form id="full-chat-form" class="d-flex gap-2">
                <input type="text" id="full-chat-input" class="form-control form-control-lg rounded-pill px-4" placeholder="Type your prompt here..." required autocomplete="off">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">
                    <span>Send</span> <i class="bi bi-send-fill ms-2 fs-6"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fullForm = document.getElementById('full-chat-form');
    const fullInput = document.getElementById('full-chat-input');
    const fullMessages = document.getElementById('full-chat-messages');

    function usePrompt(btn) {
        fullInput.value = btn.innerText;
        fullForm.dispatchEvent(new Event('submit'));
    }

    function clearChatHistory() {
        fullMessages.innerHTML = `
            <div class="bg-white p-3 rounded-4 shadow-sm mb-3 text-dark border d-flex gap-3 align-items-start" style="max-width: 85%;">
                <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <div class="fw-semibold text-primary mb-1">NovaMart AI</div>
                    <div>Chat cleared. How can I help you next?</div>
                </div>
            </div>`;
    }

    if (fullForm) {
        fullForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const message = fullInput.value.trim();
            if (!message) return;

            // Render User Message
            fullMessages.innerHTML += `
                <div class="bg-primary text-white p-3 rounded-4 shadow-sm mb-3 ms-auto small text-end" style="max-width: 80%;">
                    <div class="fw-semibold mb-1 opacity-75">You</div>
                    <div>${escapeHtml(message)}</div>
                </div>`;
            fullInput.value = '';
            fullMessages.scrollTop = fullMessages.scrollHeight;

            // Render Loading Indicator
            const loadingId = 'full-loading-' + Date.now();
            fullMessages.innerHTML += `
                <div id="${loadingId}" class="bg-white p-3 rounded-4 shadow-sm mb-3 text-muted small border d-flex align-items-center gap-2" style="max-width: 80%;">
                    <span class="spinner-border spinner-border-sm text-primary"></span> Assistant is analyzing query...
                </div>`;
            fullMessages.scrollTop = fullMessages.scrollHeight;

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

                fullMessages.innerHTML += `
                    <div class="bg-white p-3 rounded-4 shadow-sm mb-3 text-dark border d-flex gap-3 align-items-start" style="max-width: 85%;">
                        <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-primary mb-1">NovaMart AI</div>
                            <div class="lh-base" style="white-space: pre-wrap;">${escapeHtml(data.reply || 'No response available.')}</div>
                        </div>
                    </div>`;
            } catch (error) {
                if (document.getElementById(loadingId)) {
                    document.getElementById(loadingId).remove();
                }
                fullMessages.innerHTML += `
                    <div class="bg-danger text-white p-3 rounded-4 shadow-sm mb-3 small" style="max-width: 85%;">
                        Error connecting to AI Assistant API.
                    </div>`;
            }
            fullMessages.scrollTop = fullMessages.scrollHeight;
        });
    }

    function escapeHtml(text) {
        return text.replace(/[&<>"']/g, function(m) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
        });
    }
</script>
@endpush
