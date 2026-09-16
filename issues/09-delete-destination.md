# Issue 9: Retkikohteen poistaminen

**Labelit:** `backend`, `database`

## Tehtävä
Toteuttakaa retkikohteen poistaminen.

```text
DELETE /api/destinations/:id
```

## Hyväksymiskriteerit
- Kohde voidaan poistaa.
- Poistettu kohde ei enää näy listauksessa.
- Puuttuvan kohteen poistaminen käsitellään.
- Käyttäjä saa onnistumisesta selkeän vastauksen.

## Lisätiedot
Poistaminen tulee tehdä käyttäjän vahvistuksen jälkeen käyttöliittymässä.
