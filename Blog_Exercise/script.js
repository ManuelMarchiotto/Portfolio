/**
 * Gestisce la navigazione tra le sezioni del sito (SPA)
 * @param {string} pageId - L'ID della sezione da mostrare (es. 'home', 'iphone')
 * @param {PointerEvent} event - L'evento del click per gestire lo stile del menu
 */
function showPage(pageId, event) {
    // 1. Preveniamo il comportamento predefinito del link (evita il salto della pagina)
    if (event) event.preventDefault();

    // 2. Selezioniamo tutte le sezioni "pagina" e i link della navigazione
    const pages = document.querySelectorAll('.page');
    const links = document.querySelectorAll('.nav-link');

    // 3. Reset: Nascondiamo tutte le pagine e rimuoviamo lo stato "active" dai link
    pages.forEach(page => {
        page.classList.remove('active-page');
    });

    links.forEach(link => {
        link.classList.remove('active');
    });

    // 4. Attivazione: Mostriamo la pagina richiesta
    const targetPage = document.getElementById('page-' + pageId);
    if (targetPage) {
        targetPage.classList.add('active-page');
    }

    // 5. Evidenziamo il link cliccato nell'header
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}

// Opzionale: Impostiamo la pagina iniziale al caricamento del DOM
document.addEventListener('DOMContentLoaded', () => {
    console.log("Script caricato correttamente. Pronto a navigare!");
});