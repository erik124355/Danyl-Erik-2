# Valmiit GitHub issue -tiketit: Retkikohteet-sovellus

Tämä tiedosto sisältää valmiit issue-tiketit, jotka voidaan käyttää suoraan GitHubin issue-listassa.

## Labelit

- `setup`
- `database`
- `backend`
- `api`
- `frontend`
- `quality`
- `design`
- `testing`
- `documentation`

---

## Issue 1: Projektin ja Docker-ympäristön perustaminen

**Label:** `setup`

Perustakaa PHP-projekti ja Docker-ympäristö.

**Tehtävät:**

- Luo `Dockerfile`.
- Luo `docker-compose.yml`.
- Lisää PHP-palvelimen käynnistys ja tarvittavat PHP-laajennukset.
- Luo sovelluksen käynnistystiedosto.
- Lisää `.gitignore`.
- Varmista, että PHP- ja MySQL-kontit käynnistyvät.

**Hyväksymiskriteerit:**

- `docker compose up -d --build` toimii.
- Sovellus avautuu selaimessa Docker-ympäristön kautta.
- MySQL-palvelu käynnistyy sovelluksen mukana.
- Palvelin vastaa vähintään testireitillä `/`.
- Salaisuudet, lokit ja tietokannan väliaikaiset tiedostot eivät päädy GitHubiin.

---

## Issue 2: Projektin kansiorakenne

**Label:** `setup`

Suunnitelkaa ja toteuttakaa selkeä kansiorakenne.

**Esimerkkirakenne:**

```text
src/
  server.js
  routes/
  controllers/
  db/
  services/
public/
  index.html
  css/
  js/
```

**Hyväksymiskriteerit:**

- Backend- ja frontend-koodi ovat selkeästi eroteltuina.
- Kansiorakenne on dokumentoitu README-tiedostossa.
- Rakenteen tarkoitus on ymmärrettävä toiselle kehittäjälle.

---

## Issue 3: MySQL-tietokannan käyttöönotto Dockerissa

**Label:** `database`

Ottakaa MySQL käyttöön Docker Composella ja luokaa tietokannan alustaminen.

**Hyväksymiskriteerit:**

- MySQL-palvelu käynnistyy omassa kontissaan.
- Tietokanta säilyy konttien uudelleenkäynnistyksen jälkeen Docker-volumen avulla.
- Tietokannan yhteysasetukset ovat konfiguroitavissa.
- Alustus voidaan suorittaa uudelleen ilman virhettä.
- PHP-sovellus muodostaa yhteyden MySQL:ään PDO:lla.

---

## Issue 4: Retkikohteiden tietokantataulu

**Label:** `database`

Luokaa `destinations`-taulu retkikohteille.

**Taulun vähimmäiskentät:**

```text
id
name
location
description
latitude
longitude
type
difficulty
planned_date
created_at
```

**Hyväksymiskriteerit:**

- Taulussa on yksilöllinen id.
- Pakolliset kentät on määritelty.
- Tietotyypit ovat tarkoituksenmukaiset.
- Taulun rakenne on dokumentoitu.

---

## Issue 5: Retkikohteen lisääminen tietokantaan

**Label:** `database`, `backend`

Toteuttakaa toiminto, jolla uusi retkikohde tallennetaan tietokantaan.

**Hyväksymiskriteerit:**

- Uusi kohde voidaan tallentaa.
- Tiedot löytyvät tietokannasta tallennuksen jälkeen.
- Puutteellisilla tiedoilla tallennus estetään.
- Tallennuksen onnistumisesta palautetaan sopiva vastaus.

---

## Issue 6: Retkikohteiden hakeminen

**Label:** `backend`, `api`

Toteuttakaa backend-reitti kaikkien retkikohteiden hakemista varten.

```text
GET /api/destinations
```

**Hyväksymiskriteerit:**

- Reitti palauttaa JSON-muotoisen listan.
- Tiedot haetaan tietokannasta.
- Tyhjä lista palautetaan, jos kohteita ei ole.
- Tietokantavirhe käsitellään.

---

## Issue 7: Yksittäisen retkikohteen hakeminen

**Label:** `backend`, `api`

Toteuttakaa reitti yksittäisen retkikohteen hakemista varten.

```text
GET /api/destinations/:id
```

**Hyväksymiskriteerit:**

- Oikea kohde palautetaan id:n perusteella.
- Virheellinen id käsitellään.
- Puuttuvasta kohteesta palautetaan HTTP 404.
- Vastaus on JSON-muotoinen.

---

## Issue 8: Retkikohteen muokkaaminen

**Label:** `backend`, `database`

Toteuttakaa retkikohteen tietojen muokkaaminen.

```text
PUT /api/destinations/:id
```

**Hyväksymiskriteerit:**

- Olemassa olevan kohteen tiedot voidaan päivittää.
- Päivitys kohdistuu oikeaan tietueeseen.
- Puuttuva kohde käsitellään.
- Virheellinen syöte hylätään.

---

## Issue 9: Retkikohteen poistaminen

**Label:** `backend`, `database`

Toteuttakaa retkikohteen poistaminen.

```text
DELETE /api/destinations/:id
```

**Hyväksymiskriteerit:**

- Kohde voidaan poistaa.
- Poistettu kohde ei enää näy listauksessa.
- Puuttuvan kohteen poistaminen käsitellään.
- Käyttäjä saa onnistumisesta selkeän vastauksen.

---

## Issue 10: Retkikohteen lisäämislomake

**Label:** `frontend`

Rakentakaa käyttöliittymään lomake uuden retkikohteen lisäämistä varten.

Lomakkeessa tulee olla vähintään nimi, sijainti, kuvaus, leveysaste, pituusaste, tyyppi, vaikeustaso ja suunniteltu retkipäivä.

**Hyväksymiskriteerit:**

- Lomake näkyy selaimessa.
- Käyttäjä voi syöttää kaikki tarvittavat tiedot.
- Lomake lähettää tiedot backendille.
- Onnistuneen tallennuksen jälkeen käyttäjälle näytetään ilmoitus.

---

## Issue 11: Retkikohteiden listaus käyttöliittymässä

**Label:** `frontend`, `api`

Näyttäkää tietokannassa olevat retkikohteet käyttöliittymässä.

**Hyväksymiskriteerit:**

- Kohteet haetaan backendin API-reitiltä.
- Kaikki kohteet näytetään ymmärrettävässä muodossa.
- Tyhjästä listasta näytetään ilmoitus.
- API-virhe näytetään käyttäjälle.

---

## Issue 12: Yksittäisen kohteen näkymä

**Label:** `frontend`

Toteuttakaa näkymä, jossa käyttäjä voi tarkastella yhden retkikohteen tietoja.

Näytettäviä tietoja ovat nimi, sijainti, kuvaus, tyyppi, vaikeustaso, retkipäivä, koordinaatit ja sääennusteeseen johtava toiminto.

**Hyväksymiskriteerit:**

- Kohteen tiedot haetaan API:sta.
- Käyttäjä voi siirtyä takaisin listaukseen.
- Puuttuva kohde käsitellään selkeästi.

---

## Issue 13: Muokkausnäkymä

**Label:** `frontend`

Lisätkää käyttöliittymään mahdollisuus muokata retkikohteen tietoja.

**Hyväksymiskriteerit:**

- Lomake täyttyy olemassa olevilla tiedoilla.
- Käyttäjä voi tallentaa muutokset.
- Muutokset näkyvät listauksessa.
- Käyttäjä saa palautteen onnistumisesta tai virheestä.

---

## Issue 14: Poistotoiminto käyttöliittymään

**Label:** `frontend`

Lisätkää retkikohteen poistamiseen painike.

**Hyväksymiskriteerit:**

- Poistaminen vaatii käyttäjän vahvistuksen.
- Poiston jälkeen lista päivitetään.
- Käyttöliittymä ei jää virheelliseen tilaan.
- Poistovirhe näytetään käyttäjälle.

---

## Issue 15: Open-Meteo-säärajapinnan käyttö

**Label:** `api`, `backend`

Tutustukaa Open-Meteo API:n dokumentaatioon ja hakekaa retkikohteen sääennuste koordinaattien perusteella.

**Hyväksymiskriteerit:**

- Backend kutsuu ulkoista säärajapintaa.
- Käytössä ovat tietokantaan tallennetut leveys- ja pituusasteet.
- API-vastaus käsitellään backendissä.
- Ulkoisen API:n virhetilanne käsitellään.

---

## Issue 16: Sääennusteen API-reitti

**Label:** `api`, `backend`

Luokaa oma API-reitti sääennusteen hakemista varten.

```text
GET /api/destinations/:id/weather
```

**Hyväksymiskriteerit:**

- Reitti hakee kohteen koordinaatit tietokannasta.
- Reitti kutsuu Open-Meteo-rajapintaa.
- Säädata palautetaan frontendille JSON-muodossa.
- Tuntematon retkikohde palauttaa 404-vastauksen.

---

## Issue 17: Sääennusteen näyttäminen

**Label:** `frontend`, `api`

Näyttäkää sääennuste yksittäisen retkikohteen näkymässä.

Näytettäviä tietoja ovat päivämäärä, lämpötila, sademäärä tai sateen todennäköisyys, tuulen nopeus ja säätilan kuvaus.

**Hyväksymiskriteerit:**

- Sää haetaan oman backend-reitin kautta.
- Käyttäjä näkee lataustilan.
- API-virhe näytetään ymmärrettävästi.
- Sää ei vaadi API-avaimen kirjoittamista frontend-koodiin.

---

## Issue 18: Validointi ja virheenkäsittely

**Label:** `backend`, `frontend`, `quality`

Lisätkää sovellukseen kattava syötteiden tarkistus.

Tarkistettavia asioita ovat muun muassa:

- nimi ei saa olla tyhjä
- koordinaattien tulee olla numeroita
- leveysasteen tulee olla välillä `-90...90`
- pituusasteen tulee olla välillä `-180...180`
- päivämäärän tulee olla oikeassa muodossa
- vaikeustason tulee olla sallittu arvo

**Hyväksymiskriteerit:**

- Virheellisistä tiedoista annetaan selkeä ilmoitus.
- Backend ei luota pelkästään frontend-validointiin.
- Sovellus ei kaadu virheelliseen syötteeseen.
- HTTP-statuskoodit ovat tarkoituksenmukaiset.

---

## Issue 19: Käyttöliittymän viimeistely

**Label:** `frontend`, `design`

Viimeistelkää käyttöliittymän ulkoasu ja käytettävyys.

**Hyväksymiskriteerit:**

- Sovelluksen nimi näkyy selkeästi.
- Navigointi toimii.
- Lomakkeet ovat ymmärrettäviä.
- Sovellus toimii myös pienellä näytöllä.
- Painikkeiden tarkoitus on selkeä.
- Käyttäjä saa palautteen keskeisistä toiminnoista.

---

## Issue 20: Testaus ja dokumentaatio

**Label:** `testing`, `documentation`

Testatkaa sovelluksen tärkeimmät toiminnot ja dokumentoikaa projekti.

README-tiedostossa tulee olla:

- projektin tarkoitus
- käytetty teknologia
- asennusohjeet
- käynnistysohjeet
- tietokannan alustaminen
- API-reittien kuvaus
- Open-Meteo-rajapinnan käyttö
- työnjako
- tunnetut rajoitukset
- tekoälyn hyödyntäminen

**Hyväksymiskriteerit:**

- Ainakin tärkeimmät API-reitit on testattu.
- CRUD-toiminnot on testattu.
- Säärajapinnan toiminta on kokeiltu.
- README:n avulla toinen opiskelija pystyy käynnistämään projektin.

---

## Kahden päivän aikataulu

### Päivä 1: Projektin runko ja CRUD-toiminnot

**Aamupäivä**

- Tehtävän läpikäynti
- GitHub-työskentelyn kertaus
- Issueiden jakaminen
- Branchien luominen
- Projektin alustaminen
- Kansiorakenteen suunnittelu

**Iltapäivä**

- MySQL-tietokannan ja Docker-ympäristön perustaminen
- `destinations`-taulun luominen
- Backendin API-reitit
- Retkikohteen lisääminen
- Retkikohteiden listaaminen
- Ensimmäiset pull requestit

### Päivä 2: Frontend, ulkoinen API ja viimeistely

**Aamupäivä**

- Lomakkeiden toteutus
- Retkikohteiden listaus
- Muokkaus ja poistaminen
- Open-Meteo API:n käyttöönotto
- Sääennusteen näyttäminen

**Iltapäivä**

- Validointi ja virheenkäsittely
- Käyttöliittymän viimeistely
- Testaus
- README:n kirjoittaminen
- Pull requestien katselmointi
- Projektin esittely

---

## Definition of Done

Issue voidaan merkitä valmiiksi, kun:

- toiminnallisuus on toteutettu
- koodi on omassa branchissa
- commit-viesti on kuvaava
- pull request on avattu
- toinen työparin jäsen on tarkistanut muutoksen
- mahdolliset kommentit on käsitelty
- sovellus toimii muutoksen jälkeen
- issue on linkitetty pull requestiin
- dokumentaatio on päivitetty tarvittaessa

GitHubissa issue-työskentelyssä kannattaa käyttää seuraavaa prosessia:

1. Valitse avoin issue.
2. Keskustele tehtävästä parin kanssa.
3. Luo issuen perusteella oma branch.
4. Toteuta muutos.
5. Tee kuvaava commit.
6. Avaa pull request.
7. Tarkista muutos yhdessä parin kanssa.
8. Korjaa mahdolliset huomiot.
9. Mergeä pull request.
10. Sulje issue.

---

## Branchin nimi- ja commit-esimerkit

**Branchit:**

```text
feature/issue-3-database
fix/issue-12-validation
docs/issue-18-readme
```

**Commitit:**

```text
Add PHP Docker environment
Create MySQL destinations table
Add weather API endpoint
Validate destination form
```
