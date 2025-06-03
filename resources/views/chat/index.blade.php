@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-robot me-2"></i>Assistant IA
                    </h5>
                    <button class="btn btn-sm btn-light" id="clear-chat">
                        <i class="fas fa-trash-alt"></i> Effacer
                    </button>
                </div>

                <div class="card-body p-0">
                    <div id="chat-messages" class="p-4" style="height: 500px; overflow-y: auto;">
                        <!-- Messages will appear here -->
                    </div>

                    <div class="border-top p-3 bg-light">
                        <form id="chat-form" class="d-flex gap-2">
                            @csrf
                            <div class="flex-grow-1 position-relative">
                                <input type="text" id="message-input" class="form-control form-control-lg" 
                                       placeholder="Posez votre question..." autocomplete="off">
                                <div id="typing-indicator" class="position-absolute d-none" style="bottom: -25px; left: 0;">
                                    <span class="text-muted small">
                                        <i class="fas fa-circle fa-bounce"></i>
                                        <i class="fas fa-circle fa-bounce" style="animation-delay: 0.2s"></i>
                                        <i class="fas fa-circle fa-bounce" style="animation-delay: 0.4s"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4" id="send-button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.message {
    margin-bottom: 1.5rem;
    animation: fadeIn 0.3s ease-in-out;
}

.message-user {
    background-color: #e3f2fd;
    border-radius: 15px 15px 0 15px;
    padding: 1rem;
    margin-left: 20%;
}

.message-bot {
    background-color: #f5f5f5;
    border-radius: 15px 15px 15px 0;
    padding: 1rem;
    margin-right: 20%;
}

.message-content {
    white-space: pre-wrap;
}

.message-header {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.message-timestamp {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.code-block {
    background-color: #f8f9fa;
    border-radius: 5px;
    padding: 1rem;
    margin: 0.5rem 0;
    font-family: monospace;
    white-space: pre-wrap;
}

.bot-response-section {
    margin: 1rem 0;
    padding: 1rem;
    border-left: 3px solid #0d6efd;
    background-color: #f8f9fa;
}

.bot-response-section h4 {
    color: #0d6efd;
    margin-bottom: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    const clearButton = document.getElementById('clear-chat');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Fonction pour formater la réponse du bot
    function formatBotResponse(text) {
        // Détecter et formater les blocs de code
        text = text.replace(/```(\w*)\n([\s\S]*?)```/g, '<div class="code-block">$2</div>');
        
        // Détecter et formater les sections
        text = text.replace(/## (.*?)\n([\s\S]*?)(?=##|$)/g, 
            '<div class="bot-response-section"><h4>$1</h4>$2</div>');
        
        // Formater le texte en gras
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        // Formater les listes
        text = text.replace(/^\s*[-*]\s+(.*?)$/gm, '<li>$1</li>');
        text = text.replace(/(<li>.*?<\/li>\n?)+/g, '<ul>$&</ul>');
        
        return text;
    }

    function addMessageToChat(sender, message, isError = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender === 'You' ? 'message-user' : 'message-bot'}`;
        
        const header = document.createElement('div');
        header.className = 'message-header';
        header.innerHTML = sender === 'You' 
            ? '<i class="fas fa-user"></i> Vous'
            : '<i class="fas fa-robot"></i> Assistant IA';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        content.innerHTML = sender === 'You' 
            ? message
            : formatBotResponse(message);
        
        const timestamp = document.createElement('div');
        timestamp.className = 'message-timestamp';
        timestamp.textContent = new Date().toLocaleTimeString();
        
        messageDiv.appendChild(header);
        messageDiv.appendChild(content);
        messageDiv.appendChild(timestamp);
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;

        // Désactiver l'interface pendant l'envoi
        messageInput.disabled = true;
        sendButton.disabled = true;
        typingIndicator.classList.remove('d-none');

        // Ajouter le message de l'utilisateur
        addMessageToChat('You', message);
        messageInput.value = '';

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });

            if (!response.ok) {
                if (response.status === 419) {
                    throw new Error('Session expirée. Veuillez rafraîchir la page.');
                }
                const errorData = await response.json();
                throw new Error(errorData.message || 'Une erreur est survenue');
            }

            const data = await response.json();
            
            if (data.success) {
                addMessageToChat('Bot', data.message);
            } else {
                throw new Error(data.message || 'Erreur inconnue');
            }
        } catch (error) {
            console.error('Erreur chat:', error);
            addMessageToChat('Error', error.message, true);
        } finally {
            // Réactiver l'interface
            messageInput.disabled = false;
            sendButton.disabled = false;
            typingIndicator.classList.add('d-none');
            messageInput.focus();
        }
    });

    // Effacer l'historique du chat
    clearButton.addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment effacer tout l\'historique du chat ?')) {
            chatMessages.innerHTML = '';
        }
    });

    // Focus automatique sur l'input
    messageInput.focus();
});
</script>
@endpush
@endsection 