# Issue 16: Sääennusteen API-reitti

**Labelit:** `api`, `backend`

## Tehtävä
Luokaa oma API-reitti sääennusteen hakemista varten.

```text
GET /api/destinations/:id/weather
```

## Hyväksymiskriteerit
- Reitti hakee kohteen koordinaatit tietokannasta.
- Reitti kutsuu Open-Meteo-rajapintaa.
- Säädata palautetaan frontendille JSON-muodossa.
- Tuntematon retkikohde palauttaa 404-vastauksen.

## Lisätiedot
Tämä reitti toimii frontendin säänäkymän tietolähteenä.
