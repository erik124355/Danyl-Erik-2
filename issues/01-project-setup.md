# Issue 1: Projektin ja Docker-ympäristön perustaminen

**Labelit:** `setup`

## Tehtävä
Perustakaa PHP-projekti ja Docker-ympäristö.

## Työtehtävät
- Luo `Dockerfile`.
- Luo `docker-compose.yml`.
- Lisää PHP-palvelimen käynnistys ja tarvittavat PHP-laajennukset.
- Luo sovelluksen käynnistystiedosto.
- Lisää `.gitignore`.
- Varmista, että PHP- ja MySQL-kontit käynnistyvät.

## Hyväksymiskriteerit
- `docker compose up -d --build` toimii.
- Sovellus avautuu selaimessa Docker-ympäristön kautta.
- MySQL-palvelu käynnistyy sovelluksen mukana.
- Palvelin vastaa vähintään testireitillä `/`.
- Salaisuudet, lokit ja tietokannan väliaikaiset tiedostot eivät päädy GitHubiin.

## Lisätiedot
Tämä on projektin perusta, joka mahdollistaa seuraavien issueiden toteutuksen.
