# Issue 3: MySQL-tietokannan käyttöönotto Dockerissa

**Labelit:** `database`

## Tehtävä
Ottakaa MySQL käyttöön Docker Composella ja luokaa tietokannan alustaminen.

## Hyväksymiskriteerit
- MySQL-palvelu käynnistyy omassa kontissaan.
- Tietokanta säilyy konttien uudelleenkäynnistyksen jälkeen Docker-volumen avulla.
- Tietokannan yhteysasetukset ovat konfiguroitavissa.
- Alustus voidaan suorittaa uudelleen ilman virhettä.
- PHP-sovellus muodostaa yhteyden MySQL:ään PDO:lla.

## Lisätiedot
Tämä issue luo perustan tietokantaan tallennettaville retkikohteille.
