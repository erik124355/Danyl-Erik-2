# Issue 18: Validointi ja virheenkäsittely

**Labelit:** `backend`, `frontend`, `quality`

## Tehtävä
Lisätkää sovellukseen kattava syötteiden tarkistus.

## Tarkistettavia asioita
- nimi ei saa olla tyhjä
- koordinaattien tulee olla numeroita
- leveysasteen tulee olla välillä `-90...90`
- pituusasteen tulee olla välillä `-180...180`
- päivämäärän tulee olla oikeassa muodossa
- vaikeustason tulee olla sallittu arvo

## Hyväksymiskriteerit
- Virheellisistä tiedoista annetaan selkeä ilmoitus.
- Backend ei luota pelkästään frontend-validointiin.
- Sovellus ei kaadu virheelliseen syötteeseen.
- HTTP-statuskoodit ovat tarkoituksenmukaiset.

## Lisätiedot
Validoinnin tulee toimia sekä käyttöliittymässä että backendissä.
