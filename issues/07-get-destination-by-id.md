# Issue 7: Yksittäisen retkikohteen hakeminen

**Labelit:** `backend`, `api`

## Tehtävä
Toteuttakaa reitti yksittäisen retkikohteen hakemista varten.

```text
GET /api/destinations/:id
```

## Hyväksymiskriteerit
- Oikea kohde palautetaan id:n perusteella.
- Virheellinen id käsitellään.
- Puuttuvasta kohteesta palautetaan HTTP 404.
- Vastaus on JSON-muotoinen.

## Lisätiedot
Tämä reitti tukee yhden kohteen tarkastelua ja muokkausta.
