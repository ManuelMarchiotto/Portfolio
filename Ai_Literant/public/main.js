const input = document.getElementById('user-input');
const output = document.getElementById('chat-output');

input.addEventListener('keypress', async (e) => {
    if (e.key === 'Enter') {
        const val = input.value;
        appendMessage('user', val);
        input.value = '';

        const res = await fetch('/api/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prompt: val })
        });

        const data = await res.json();
        processAIResponse(data.text);
    }
});

function appendMessage(role, text) {
    const div = document.createElement('div');
    div.className = `message-wrap ${role}`;
    div.innerHTML = `
        <div class="process-header">[${role.toUpperCase()} // SESSION_ID_01]</div>
        <p class="${role === 'assistant' ? 'text-white' : ''}">${text}</p>
    `;
    output.appendChild(div);
    output.scrollTop = output.scrollHeight;
}

function processAIResponse(text) {
    // Se l'AI decide di mostrare i progetti
    if (text.includes('[TRIGGER_PROJECTS]')) {
        document.getElementById('project-zone').style.display = 'grid';
        injectProjects();
    }
    appendMessage('assistant', text.replace('[TRIGGER_PROJECTS]', ''));
}

function injectProjects() {
    const zone = document.getElementById('project-zone');
    const projects = [
        { name: "Neural Dashboard", tech: "Next.js" },
        { name: "Vapor Terminal", tech: "Rust" }
    ];
    zone.innerHTML = projects.map(p => `
        <div class="project-card">
            <span class="mono-text" style="font-size:10px">${p.tech}</span>
            <h3 style="color:white">${p.name}</h3>
        </div>
    `).join('');
}

async function handleChat() {
    const val = input.value;
    if(!val) return;
    
    appendMessage('user', val);
    input.value = '';

    const res = await fetch('/api/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ prompt: val })
    });

    const data = await res.json();
    
    // Update Debug Sidebar
    updateDebugInfo(data.debug);
    
    // Process Response
    processAIResponse(data.text);
}

function updateDebugInfo(debug) {
    if(!debug) return;
    document.getElementById('debug-latency').innerText = debug.latency;
    document.getElementById('debug-tokens').innerText = debug.tokens;
    document.getElementById('debug-model').innerText = debug.model;
    
    // Log nel terminale di debug
    console.log(`[SYS] Response received in ${debug.latency}`);
}
