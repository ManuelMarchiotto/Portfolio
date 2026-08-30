# E-commerce

Table utenti {
    id integer [pk]
    nome varchar
    cognome varchar
    data_nascita date
    email varchar
    indirizzo varchar
    citta varchar
    telefono varchar
}

Table libri {
    id integer [pk]
    titolo varchar
    autore varchar
    anno_pubblicazione varchar
    quantita_magazzino integer
}

Table ordini {
    id integer [pk]
    utente_id integer
    libro_id integer
    data_ordine date
    stato_pagamento varchar
    citta_spedizione varchar
    indirizzo_spedizione varchar
}

Ref: ordini.utente_id > utenti.id
Ref: ordini.libro_id > libri.id

# Social Network

Table utenti {
    id integer [pk]
    nome_utente varchar
    email varchar
    foto_profilo varchar
}

Table post {
    id integer [pk]
    contenuto varchar
    data_pubblicazione date
    utente_id integer
}

Table like {
    id integer [pk]
    utente_id integer
    post_id integer
    data_like date
}

Ref: post.utente_id > utenti.id
Ref: like.utente_id > utenti.id
Ref: like.post_id > post.id

# Sito di Annunci

Table utenti {
    id integer [pk]
    nome varchar
    cognome varchar
    data_nascita date
    email varchar
    ruolo varchar
}

Table categorie {
    id integer [pk]
    nome varchar
}

Table annunci {
    id integer [pk]
    titolo varchar
    descrizione varchar
    utente_id integer
    categoria_id integer
    data_inserimento date
    accettato varchar
}

Ref: annunci.utente_id > utenti.id
Ref: annunci.categoria_id > categorie.id
