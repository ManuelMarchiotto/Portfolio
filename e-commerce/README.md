# UrbanWear

UrbanWear è un e-commerce di abbigliamento streetwear sviluppato come progetto portfolio full stack. L'obiettivo è realizzare un'applicazione moderna, responsive e completa: dalla scoperta dei prodotti fino alla gestione degli ordini.

## Tecnologie

- **Backend:** PHP 8.5 e Laravel 13
- **Frontend:** Blade, HTML, Tailwind CSS e JavaScript
- **Database:** SQLite in sviluppo; MySQL previsto per la pubblicazione
- **Build frontend:** Vite

> Per questa applicazione usiamo Tailwind CSS. Bootstrap non viene incluso: usare entrambi nello stesso progetto renderebbe lo stile più difficile da mantenere.

## Funzionalità previste

- Catalogo prodotti con categorie e filtri
- Pagina di dettaglio prodotto
- Carrello persistente
- Registrazione, accesso e profilo utente
- Checkout e storico ordini
- Lista dei desideri
- Recensioni prodotto
- Area amministratore per gestire prodotti, categorie e ordini
- Layout responsive per desktop e mobile

## Roadmap

- [x] Creazione del progetto Laravel e configurazione iniziale
- [x] Configurazione di Tailwind CSS e Vite
- [x] Progettazione delle pagine e dell'esperienza utente
- [x] Layout pubblico: navbar, footer e homepage
- [x] Modelli e migrazioni: categorie e prodotti
- [x] Catalogo, ricerca e filtri
- [ ] Autenticazione utenti
- [ ] Carrello e checkout
- [ ] Ordini e area amministratore
- [ ] Test, screenshot e pubblicazione online

## Avvio in locale

Installa le dipendenze frontend e avvia l'ambiente di sviluppo:

```bash
npm install
composer run dev
```

L'applicazione sarà disponibile all'indirizzo indicato nel terminale. In alternativa, puoi avviare separatamente il server Laravel e Vite:

```bash
php artisan serve
npm run dev
```

## Stato del progetto

**Fase attuale:** catalogo e pagina dettaglio prodotto completati. Il prossimo passo è mostrare e gestire il carrello.

## Database

Le tabelle principali introdotte in questa fase sono:

- `categories`: nome, slug, descrizione e immagine della categoria.
- `products`: categoria, nome, slug, SKU, descrizione, prezzi, disponibilità, colore, taglie, immagine e flag di pubblicazione.

Ogni prodotto appartiene a una categoria. Le taglie sono memorizzate come elenco JSON, così da supportare facilmente articoli con disponibilità diverse.

Il catalogo demo comprende tre categorie e sei prodotti. Per ripristinarlo o aggiornare i dati in sviluppo:

```bash
php artisan db:seed
```

## Catalogo

La pagina `/catalogo` mostra i prodotti attivi e supporta ricerca per nome o SKU, categoria, intervallo di prezzo, disponibilità e ordinamento. I filtri sono parametri URL, quindi il risultato di una ricerca può essere condiviso o salvato.

## Pagina prodotto

Ogni prodotto ha una pagina dedicata con descrizione, colore, stock, taglie e prodotti correlati. L'utente può selezionare taglia e quantità, poi aggiungere l'articolo al carrello di sessione.
