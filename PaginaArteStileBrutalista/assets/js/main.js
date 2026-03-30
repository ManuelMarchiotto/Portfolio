/**
 * THE ARCHITECTURAL GALLERY - Core Engine v2
 * Inclusa gestione errori immagini e transizioni fluide.
 */

// Forza la visibilità immediata del body per evitare schermate bianche
gsap.set("body", { opacity: 1, visibility: "visible" });

document.addEventListener('DOMContentLoaded', () => {

    // --- 1. INIZIALIZZAZIONE SMOOTH SCROLL (Lenis) ---
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);


    // --- 2. GESTIONE IMMAGINI (Anti-Icone Rotte) ---
    const allImages = document.querySelectorAll('img');
    
    allImages.forEach(img => {
        // Se l'immagine fallisce il caricamento, la nascondiamo completamente
        // Rimarrà visibile solo il background grigio del contenitore (CSS)
        img.addEventListener('error', function() {
            this.style.opacity = '0';
            this.parentElement.style.backgroundColor = '#e1e3e4'; // fallback grigio
        });

        // Quando l'immagine è caricata, aggiungiamo una classe per animarla
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', () => {
                img.classList.add('loaded');
            });
        }
    });


    // --- 3. ANIMAZIONI DI ENTRATA (GSAP + ScrollTrigger) ---
    gsap.registerPlugin(ScrollTrigger);

    // Animazione Elementi Testuali
    const revealElements = document.querySelectorAll('.display-lg, .headline-lg, .body-md, .btn-primary, .label-md');
    
    revealElements.forEach((el) => {
        gsap.from(el, {
            scrollTrigger: {
                trigger: el,
                start: "top 92%",
                toggleActions: "play none none none"
            },
            y: 30,
            opacity: 0,
            duration: 1,
            ease: "power2.out"
        });
    });

    // Animazione Card Galleria
    gsap.utils.toArray('.artwork-card, .skill-card').forEach((card) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: "top 85%",
            },
            y: 60,
            opacity: 0,
            duration: 1.2,
            ease: "expo.out"
        });
    });


    // --- 4. TRANSIZIONI TRA PAGINE ---
    const links = document.querySelectorAll('a');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');

            // Procedi solo se è un link interno valido
            if (href && !href.startsWith('#') && link.hostname === window.location.hostname) {
                e.preventDefault();
                
                gsap.to("main", {
                    opacity: 0,
                    y: -10,
                    duration: 0.5,
                    ease: "power2.in",
                    onComplete: () => {
                        window.location.href = href;
                    }
                });
            }
        });
    });


    // --- 5. CURSORE PERSONALIZZATO ---
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    document.body.appendChild(cursor);

    window.addEventListener('mousemove', e => {
        gsap.to(cursor, {
            x: e.clientX,
            y: e.clientY,
            duration: 0.4,
            ease: "power2.out"
        });
    });

    // Interazione cursore su link e bottoni
    const hoverElements = document.querySelectorAll('a, button, .artwork-card');
    hoverElements.forEach(el => {
        el.addEventListener('mouseenter', () => gsap.to(cursor, { scale: 2.5, backgroundColor: "rgba(0,0,0,0.05)", border: "1px solid #000" }));
        el.addEventListener('mouseleave', () => gsap.to(cursor, { scale: 1, backgroundColor: "#000", border: "none" }));
    });

});