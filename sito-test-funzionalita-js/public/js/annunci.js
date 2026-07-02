// 1. Funzione che si occupa SOLO di mostrare le card nel DOM
function showAnnouncements(announcementDto, row){
    while(row.hasChildNodes()){
        row.removeChild(row.firstChild);
    }

    if(announcementDto.length <= 0){
        const col = document.createElement("div");
        col.className = "col-12 text-center my-5";
        col.innerHTML = `<p class="lead text-muted">Nessun annuncio trovato con i criteri di ricerca selezionati.</p>`;
        row.appendChild(col);
        return;
    }

    announcementDto.forEach(announcement => {       
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6 col-xl-4 mb-4';
        row.appendChild(col);

        const card = document.createElement('div');
        card.className = 'card h-100';
        col.appendChild(card);

        const imgContainer = document.createElement('div');
        imgContainer.className = 'position-relative';
        card.appendChild(imgContainer);

        const img = document.createElement('img');
        img.src = "https://picsum.photos/seed/picsum/800/600";
        img.className = 'card-img-top';
        img.alt = announcement.name || "Immagine annuncio";
        imgContainer.appendChild(img);

        const badge = document.createElement('span');
        badge.className = `position-absolute top-0 end-0 badge text-uppercase px-4 py-2 ${
        announcement.type === 'sell' ? 'text-bg-danger' : 'text-bg-primary'
        }`;
        badge.textContent = announcement.type || 'sell';
        imgContainer.appendChild(badge);

        const cardBody = document.createElement('div');
        cardBody.className = 'card-body d-flex flex-column';
        card.appendChild(cardBody);

        const priceSpan = document.createElement('span');
        priceSpan.className = 'card-subtitle d-inline-block mb-1 text-primary fw-bold fs-5';
        priceSpan.textContent = `€ ${announcement.price}`;
        cardBody.appendChild(priceSpan);

        const title = document.createElement('h5');
        title.className = 'card-title display-6';
        title.textContent = announcement.name;
        cardBody.appendChild(title);

        const description = document.createElement('p');
        description.className = 'card-text flex-grow-1';
        description.textContent = "Some quick example text to build on the card title and make up the bulk of the card’s content.";
        cardBody.appendChild(description);

        const cardFooter = document.createElement('div');
        cardFooter.className = 'card-footer bg-white d-flex justify-content-between border-top-0 pt-3';
        cardBody.appendChild(cardFooter);

        const btnLike = document.createElement('button');
        btnLike.className = 'btn p-2 text-primary';
        btnLike.innerHTML = `<i class="bi bi-heart-fill"></i> <span class="ms-2">Like</span>`;
        cardFooter.appendChild(btnLike);

        const btnCategory = document.createElement('button');
        btnCategory.className = 'btn p-2 text-primary';
        btnCategory.innerHTML = `<i class="bi bi-tag-fill"></i> <span class="ms-2">${announcement.category || 'Elettronica'}</span>`;
        cardFooter.appendChild(btnCategory);

        const btnDate = document.createElement('button');
        btnDate.className = 'btn p-2 text-primary';
        btnDate.innerHTML = `<i class="bi bi-calendar"></i> <span class="ms-2">${announcement.date || 'Data'}</span>`;
        cardFooter.appendChild(btnDate);
    });
}

// 2. Funzione per caricare i dati dal server
async function loadAnnouncements(){
    const response = await fetch('./server/api/annunci.json');
    const announcementDto = await response.json();
    return announcementDto;
}

// ==========================================
// NUOVA FUNZIONE PER POPOLARE LE CATEGORIE
// ==========================================
function populateCategorySelect(announcements, selectElement) {
    // Estrae tutte le categorie e crea un Set per eliminare i duplicati
    const categories = new Set(announcements.map(announcement => announcement.category));
    
    // Cicla sulle categorie uniche
    categories.forEach(category => {
        // Ignora eventuali valori nulli o indefiniti nel JSON
        if (category) { 
            const option = document.createElement('option');
            option.value = category;       // Assegna il nome della categoria come value
            option.textContent = category; // Assegna il nome della categoria come testo visibile
            selectElement.appendChild(option);
        }
    });
}

// 3. Funzione a monte per filtro e ordine
function filterAndSortAnnouncements(announcements, filters) {
    let filtered = announcements.filter((announcement) => {
        let isAnnouncementRequired = true;

        if(isAnnouncementRequired && filters.search){
            isAnnouncementRequired = announcement.name.toLowerCase().includes(filters.search.toLowerCase());
        }

        if(isAnnouncementRequired && filters.category && filters.category !== "Tutti gli annunci"){
            isAnnouncementRequired = announcement.category == filters.category;
        }

        const announcementPrice = parseFloat(announcement.price);

        if(isAnnouncementRequired && filters.minPrice !== ""){
            isAnnouncementRequired = announcementPrice >= parseFloat(filters.minPrice);
        }

        if(isAnnouncementRequired && filters.maxPrice !== ""){
            isAnnouncementRequired = announcementPrice <= parseFloat(filters.maxPrice);
        }

        return isAnnouncementRequired;
    });

    if(filters.sortBy) {
        switch(filters.sortBy){
            case "ascByPrice":
                filtered.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
                break;
            case "descByPrice":
                filtered.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
                break;
            case "ascByAlpha": 
                filtered.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case "descByAlpha":
                filtered.sort((a, b) => b.name.localeCompare(a.name));
                break;
        }
    }

    return filtered;
}

// 4. Gestore del DOM globale
document.addEventListener('DOMContentLoaded', async () => {
    
    const announcementsRow = document.getElementById('announcementsRow');
    const categorySelect = document.getElementById("categorySelect");
    
    const announcementDto = await loadAnnouncements();
    
    // Genera dinamicamente le categorie nella select non appena i dati sono pronti
    populateCategorySelect(announcementDto, categorySelect);
    
    // Caricamento iniziale di tutti gli annunci
    showAnnouncements(announcementDto, announcementsRow);

    // Cattura degli altri elementi della form
    const searchInput = document.getElementById("searchInput");
    const minPriceInput = document.getElementById("minPriceInput");
    const maxPriceInput = document.getElementById("maxPriceInput");
    const sortSelect = document.getElementById("sortSelect"); 
    const searchForm = document.getElementById("searchForm");

    // Evento Submit della form
    searchForm.addEventListener("submit", (event) => {
        event.preventDefault(); 
        
        const currentFilters = {
            search: searchInput.value,
            category: categorySelect.value,
            minPrice: minPriceInput.value,
            maxPrice: maxPriceInput.value,
            sortBy: sortSelect.value
        };

        const results = filterAndSortAnnouncements(announcementDto, currentFilters);
        showAnnouncements(results, announcementsRow);
    });
});