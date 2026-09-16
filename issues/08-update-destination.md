# Issue 8: Retkikohteen muokkaaminen

**Labelit:** `backend`, `database`

## Tehtävä
Toteuttakaa retkikohteen tietojen muokkaaminen.

```text
PUT /api/destinations/:id
```

## Hyväksymiskriteerit
- Olemassa olevan kohteen tiedot voidaan päivittää.
- Päivitys kohdistuu oikeaan tietueeseen.
- Puuttuva kohde käsitellään.
- Virheellinen syöte hylätään.

## Lisätiedot
Muokkausreitti pitää pitää käyttäjän muutokset synkronoituna tietokannan kanssa.
