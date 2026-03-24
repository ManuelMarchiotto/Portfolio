document.addEventListener('DOMContentLoaded', () => {
    const mainContent = document.querySelector('main');
    const navLinks = document.querySelectorAll('.nav-link');

    // --- 1. ENTRATA ---
    if (mainContent) {
        // Usiamo un piccolo timeout per assicurarci che il CSS sia applicato
        setTimeout(() => {
            mainContent.classList.add('loaded');
        }, 100);
    }

    // --- 2. LOGICA MENU ATTIVO ---
    const currentPage = window.location.pathname.split("/").pop() || "index.html";
    
    navLinks.forEach(link => {
        // Rimuove e aggiunge la classe active correttamente
        link.classList.remove('active');
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }

        // --- 3. USCITA (Transizione al click) ---
        link.addEventListener('click', e => {
            const destination = link.href;

            // Controlla che sia un link interno e non apra in nuova scheda
            if (link.hostname === window.location.hostname && !link.target) {
                e.preventDefault(); // Blocca il salto immediato
                
                mainContent.classList.add('fade-out');

                // Aspetta la fine della transizione (500ms come nel CSS)
                setTimeout(() => {
                    window.location.href = destination;
                }, 500);
            }
        });
    });
});

// Fix per il tasto "Indietro" del browser
window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        const mainContent = document.querySelector('main');
        mainContent.classList.remove('fade-out');
        mainContent.classList.add('loaded');
    }
});