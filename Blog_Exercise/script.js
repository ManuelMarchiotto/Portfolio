document.addEventListener('DOMContentLoaded', () => {
    
    // 1. EFFETTO DISSOLVENZA ALL'ENTRATA
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.style.opacity = '0';
        mainContent.style.transition = 'opacity 0.6s ease-out';
        setTimeout(() => {
            mainContent.style.opacity = '1';
        }, 50);
    }

    // 2. LOGICA PER COLORARE IL MENU ATTIVO
    // Prende il nome del file attuale (es. "iphone.html")
    const currentPage = window.location.pathname.split("/").pop();
    
    // Se siamo nella home (URL vuota o index.html)
    const activeFileName = (currentPage === "" || currentPage === "index.html") ? "index.html" : currentPage;

    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        // Rimuoviamo preventivamente ogni classe active
        link.classList.remove('active');
        
        // Se l'attributo href del link corrisponde al file attuale, aggiungiamo 'active'
        if (link.getAttribute('href') === activeFileName) {
            link.classList.add('active');
        }
    });
});