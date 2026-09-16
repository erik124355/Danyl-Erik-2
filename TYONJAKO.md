# Tyonjako ja GitHub-tyoskentely

## Suositeltu tyonjako

Työpari voi jakaa ensimmäisen työpäivän tehtävät seuraavasti:

### Kehittaja A: projektin perusta ja backend

- Issue #1: Projektin perustaminen
- Issue #2: Projektin kansiorakenne
- Issue #3: SQLite-tietokannan käyttöönotto
- Issue #4: Retkikohteiden tietokantataulu
- Issue #5: Retkikohteen lisääminen tietokantaan
- Issue #6: Retkikohteiden hakeminen
- Issue #7: Yksittäisen retkikohteen hakeminen
- Issue #8: Retkikohteen muokkaaminen
- Issue #9: Retkikohteen poistaminen

### Kehittaja B: käyttöliittymä

- Issue #10: Retkikohteen lisäämislomake
- Issue #11: Retkikohteiden listaus käyttöliittymässä
- Issue #12: Yksittäisen kohteen näkymä
- Issue #13: Muokkausnäkymä
- Issue #14: Poistotoiminto käyttöliittymään

### Yhdessä tehtavat

- Issue #15: Open-Meteo-säärajapinnan käyttö
- Issue #16: Sääennusteen API-reitti
- Issue #17: Sääennusteen näyttäminen
- Issue #18: Validointi ja virheenkäsittely
- Issue #19: Käyttöliittymän viimeistely
- Issue #20: Testaus ja dokumentaatio

Jakoa voi muuttaa tilanteen mukaan. Tärkeintä on, että jokaisella issuella on yksi vastuuhenkilö ja toinen pari toimii katselmoijana.

## Tyoskentelymalli

1. Valitse issue ja sovi vastuuhenkilö.
2. Luo issuen mukainen branch.
3. Toteuta vain kyseiseen issueen kuuluva muutos.
4. Tee kuvaava commit.
5. Avaa pull request ja käytä repositoryn PR-mallia.
6. Lisää toinen työparin jäsen katselmoijaksi.
7. Tarkista toiminnallisuus ja testit yhdessä.
8. Korjaa katselmoinnin huomiot.
9. Mergeä pull request ja sulje issue.

## Branch-nimien malli

Yksi issue, yksi branch ja yksi pull request:

```text
feature/issue-01-project-setup
feature/issue-03-sqlite-setup
feature/issue-10-add-destination-form
feature/issue-15-open-meteo
fix/issue-18-validation
docs/issue-20-testing-documentation
```

Käytä `feature/`-alkua uudelle toiminnolle, `fix/`-alkua virheenkorjaukselle ja
`docs/`-alkua dokumentaatiolle. Pidä nimi lyhyenä ja käytä pieniä kirjaimia.

## Branch-nimet kaikille issueille

| Issue | Branch |
| --- | --- |
| #1 | `feature/issue-01-project-setup` |
| #2 | `feature/issue-02-project-structure` |
| #3 | `feature/issue-03-sqlite-setup` |
| #4 | `feature/issue-04-destinations-table` |
| #5 | `feature/issue-05-create-destination` |
| #6 | `feature/issue-06-list-destinations` |
| #7 | `feature/issue-07-get-destination` |
| #8 | `feature/issue-08-update-destination` |
| #9 | `feature/issue-09-delete-destination` |
| #10 | `feature/issue-10-add-destination-form` |
| #11 | `feature/issue-11-destination-listing` |
| #12 | `feature/issue-12-destination-view` |
| #13 | `feature/issue-13-edit-destination-view` |
| #14 | `feature/issue-14-delete-destination-ui` |
| #15 | `feature/issue-15-open-meteo` |
| #16 | `feature/issue-16-weather-api-route` |
| #17 | `feature/issue-17-weather-forecast` |
| #18 | `fix/issue-18-validation-errors` |
| #19 | `feature/issue-19-ui-polish` |
| #20 | `docs/issue-20-testing-documentation` |

## Definition of Done

- Toiminnallisuus on toteutettu.
- Muutos on omassa branchissa ja pull requestissa.
- Toinen pari on katselmoinut muutoksen.
- Testit ja manuaaliset tarkistukset on tehty.
- Pull request linkittää issueen esimerkiksi tekstillä `Closes #12`.
- Dokumentaatio on ajan tasalla.
