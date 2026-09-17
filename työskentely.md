# Tiimi-projektin työskentelyohje oppilaille

Tässä ohjeessa käydään läpi, miten työskentelette pareittain GitHubin ja Git-komentojen avulla.

Projektin repository:

```text
https://github.com/Savo-Consortium-of-Education/tiimi
```

## 1. Työskentelyn perusidea

Työ tehdään yhden issuen ympärillä:

1. Valitkaa avoin issue GitHubista.
2. Sopikaa, kumpi toteuttaa tehtävän ja kumpi tarkistaa sen.
3. Luokaa issuelle oma branch.
4. Toteuttakaa muutos omassa branchissa.
5. Tehkää kuvaava commit.
6. Pushatkaa branch GitHubiin.
7. Avatkaa pull request.
8. Toinen pari tarkistaa muutoksen.
9. Korjatkaa mahdolliset huomiot.
10. Mergeä pull request ja sulkekaa issue.

Hyvä nyrkkisääntö:

```text
1 issue = 1 branch = 1 pull request
```

## 2. Tarvittavat ohjelmat

Tarvitsette:

- Gitin
- Dockerin ja Docker Composen
- PHP:n (tarvittaessa editorin syntaksitukea varten)
- koodieditorin, esimerkiksi Visual Studio Coden
- GitHub-tunnuksen

Tarkistakaa asennukset:

```bash
git --version
docker --version
docker compose version
php --version
```

Jos jokin komento ei toimi, pyytäkää opettajalta apua ennen työskentelyn jatkamista.

## 3. Repositoryn lataaminen ensimmäisellä kerralla

Valitkaa tietokoneelta kansio, johon projekti tallennetaan. Suorittakaa komennot siinä kansiossa:

```bash
git clone https://github.com/Savo-Consortium-of-Education/tiimi.git
cd tiimi
```

`git clone` lataa projektin omalle tietokoneelle. `cd tiimi` siirtyy projektikansioon.
Projektin PHP- ja MySQL-palvelut käynnistetään Dockerilla.

Käynnistäkää harjoitusympäristö:

```bash
docker compose up -d --build
```

Katsokaa käynnissä olevat kontit:

```bash
docker compose ps
```

Lopettakaa ympäristö työskentelyn jälkeen:

```bash
docker compose down
```

Älkää käyttäkö `docker compose down -v` -komentoa ilman opettajan lupaa, koska se
poistaa myös MySQL-tietokannan volumet.

## 4. Kopioikaa projekti oman tiimin repositoryyn

Kloonaamisen jälkeen projekti pitää kopioida oman tiimin GitHub-repositoryyn.
Esimerkissä oman tiimin repository on:

```text
https://github.com/Savo-Consortium-of-Education/tiimi1.git
```

Opettaja tai tiimi luo tämän repositoryn ensin GitHubissa. Repositoryn nimenä voi olla
esimerkiksi `tiimi1`, `tiimi2` tai opettajan antama muu nimi.

Tarkistakaa ensin, missä repositoryssa olette:

```bash
git remote -v
```

Kloonauksen jälkeen `origin` osoittaa yleensä alkuperäiseen yhteiseen `tiimi`-repoon.
Nimetkää alkuperäinen repository nimellä `upstream` ja lisätkää oman tiimin repository
uudeksi `origin`-osoitteeksi:

```bash
git remote rename origin upstream
git remote add origin https://github.com/Savo-Consortium-of-Education/tiimi1.git
git remote -v
```

Tuloksena pitäisi olla:

```text
origin   https://github.com/Savo-Consortium-of-Education/tiimi1.git
upstream https://github.com/Savo-Consortium-of-Education/tiimi.git
```

Lähettäkää projektin nykyinen `main`-haara oman tiimin repositoryyn:

```bash
git push -u origin main
```

Tämän jälkeen tarkistakaa GitHubissa, että projekti näkyy oman tiimin repositoryssa.
Jatkossa käyttämänne `git push` lähettää muutokset oman tiimin repositoryyn.

Jos opettaja julkaisee myöhemmin alkuperäiseen yhteiseen repositoryyn uusia muutoksia,
voitte hakea ne näin:

```bash
git fetch upstream
git switch main
git merge upstream/main
git push origin main
```

Älkää tehkö omia muutoksia suoraan `upstream`-repositoryyn. Tehkää työ aina oman tiimin
repositoryssa ja sen brancheissa.

## 5. Ennen uuden tehtävän aloittamista

Päivittäkää paikallinen `main`-haara ennen uuden branchin luomista:

```bash
git switch main
git pull origin main
```

Valitkaa työ GitHubin avoimista issueista. Lukekaa issuen tehtävä ja hyväksymiskriteerit
ennen kuin aloitatte koodaamisen.

## 6. Branchin luominen

Luokaa uusi branch issuen numeron perusteella. Esimerkiksi issue #10:

```bash
git switch -c feature/issue-10-add-destination-form
```

Branch-nimen malli:

```text
feature/issue-<numero>-<lyhyt-kuvaus>
```

Käytä seuraavia alkuja:

- `feature/` uuden toiminnallisuuden tekemiseen
- `fix/` virheen korjaamiseen
- `docs/` dokumentaation tekemiseen

Esimerkkejä:

```bash
git switch -c feature/issue-03-mysql-docker-setup
git switch -c fix/issue-18-validation-errors
git switch -c docs/issue-20-readme
```

## 7. Muutosten tekeminen

Toteuttakaa vain valittuun issueen kuuluva työ. Testatkaa sovellusta muutosten aikana.

Tarkistakaa projektin tila:

```bash
git status
```

Tarkistakaa, mitä koodissa muuttui:

```bash
git diff
```

Älkää lisätkö salasanoja, API-avaimia, Dockerin lokitiedostoja tai tietokantatiedostoja
committiin, ellei projektin ohjeissa erikseen sanota niin.

## 8. Commitin tekeminen

Lisätkää halutut tiedostot staging-alueelle:

```bash
git add .
```

Tarkistakaa vielä, mitä on menossa committiin:

```bash
git status
```

Tehkää kuvaava commit:

```bash
git commit -m "Add destination form"
```

Hyvä commit kertoo tekemisen:

```text
Create destinations table
Add destination API route
Validate destination form
Display weather forecast
Update project documentation
```

Välttäkää tällaisia commit-viestejä:

```text
muutoksia
fix
testi
kaikki valmiiksi
```

## 9. Branchin pushaminen GitHubiin

Kun työ on commitissa, pushatkaa branch GitHubiin:

```bash
git push -u origin feature/issue-10-add-destination-form
```

Ensimmäinen push tarvitsee `-u`-option. Sen jälkeen riittää:

```bash
git push
```

## 10. Pull requestin avaaminen

Menkää GitHubissa repositoryyn ja avatkaa pushatusta branchista pull request.

Pull requestin otsikko voi olla esimerkiksi:

```text
Add destination form
```

Kuvaustekstissä kertokaa:

- mitä toteutitte
- miten testasitte muutoksen
- mitä mahdollisesti jäi kesken
- kuka tarkistaa muutoksen

Linkittäkää issue käyttämällä esimerkiksi:

```text
Closes #10
```

Kun pull request yhdistetään, GitHub sulkee siihen linkitetyn issuen automaattisesti.

Repositoryssa on valmis PR-pohja tiedostossa
`.github/PULL_REQUEST_TEMPLATE.md`. Täyttäkää kaikki kohdat huolellisesti.

## 11. Toisen parin tekemä katselmointi

Toinen pari tarkistaa pull requestin ennen mergeä.

Tarkistakaa ainakin:

- vastaako toteutus issuen vaatimuksia
- toimiiko sovellus normaalitilanteessa
- toimivatko virhetilanteet
- ovatko nimet ja rakenne ymmärrettäviä
- onko mukana turhaa tai debug-koodia
- onko dokumentaatio päivitetty tarvittaessa

Jos kaikki on kunnossa, valitkaa GitHubissa **Approve**.
Jos muutettavaa löytyy, kirjoittakaa selkeä kommentti kyseiseen koodikohtaan.

## 12. Pull requestin kommenttien korjaaminen

Pysykää omassa branchissa ja tehkää korjaukset siellä:

```bash
git status
git add .
git commit -m "Address review feedback"
git push
```

Uutta pull requestia ei tarvitse avata. Uusi push päivittyy samaan pull requestiin.

## 13. Pull requestin mergeäminen

Kun:

- toteutus on valmis
- testit on tehty
- toinen pari on hyväksynyt pull requestin
- kaikki kommentit on käsitelty

mergeätkää pull request GitHubissa. Suositeltu vaihtoehto tässä harjoituksessa on
**Squash and merge**, jos opettaja ei ole antanut muuta ohjetta.

Mergen jälkeen päivittäkää oma paikallinen `main`:

```bash
git switch main
git pull origin main
```

Valinnaisesti käyttämättömän paikallisen branchin voi poistaa:

```bash
git branch -d feature/issue-10-add-destination-form
```

## 14. Seuraavan issuen aloittaminen

Aloittakaa aina päivitetystä `main`-haarasta:

```bash
git switch main
git pull origin main
git switch -c feature/issue-11-destination-listing
```

Älkää luoko uutta branchia vanhan työbranchin pohjalta, jos tehtävät eivät kuulu samaan
pull requestiin.

## 15. Jos Git ilmoittaa merge-konfliktista

Merge-konflikti tarkoittaa, että kaksi henkilöä on muuttanut samaa koodikohtaa eri tavalla.

Päivittäkää ensin main:

```bash
git switch main
git pull origin main
git switch oma-branch
git merge main
```

Git merkitsee ristiriitaisen kohdan tiedostoon. Avatkaa tiedosto editorissa ja päättäkää,
mitkä muutokset säilytetään. Poistakaa konfliktimerkinnät:

```text
<<<<<<< HEAD
oma muutos
=======
main-haaran muutos
>>>>>>> main
```

Kun tiedosto on korjattu:

```bash
git add korjattu-tiedosto.js
git commit -m "Resolve merge conflict"
git push
```

Jos ette tiedä, kumpi ratkaisu on oikea, älkää arvailko. Kysykää parilta tai opettajalta.

## 16. Hyödylliset tarkistuskomennot

Näytä nykyinen branch:

```bash
git branch --show-current
```

Näytä kaikki branchit:

```bash
git branch
```

Näytä viimeisimmät commitit:

```bash
git log --oneline --max-count=5
```

Näytä yhteys GitHub-repositoryyn:

```bash
git remote -v
```

## 17. Tyypillisiä ongelmia

### `git push` hylätään

Päivittäkää ensin main ja tarkistakaa, että olette oikeassa branchissa:

```bash
git status
git pull origin main
```

Jos olette työbranchissa ja pull request on jo avattu, älkää vaihtako branchia kesken
työn. Pyytäkää tarvittaessa opettajalta apua.

### Muutokset eivät näy GitHubissa

Tarkistakaa, että:

```bash
git status
git log --oneline --max-count=3
git push
```

Commitointi yksin ei lähetä muutoksia GitHubiin. Myös `git push` tarvitaan.

### Olette väärässä branchissa

Tarkistakaa branch:

```bash
git branch --show-current
```

Jos ette ole vielä commitoineet muutoksia, voitte vaihtaa oikeaan branchiin.
Jos olette epävarmoja, pysähtykää ja kysykää apua. Älkää poistako muutoksia sokkona.

## 18. Päivän lopun tarkistuslista

- [ ] Työ liittyy olemassa olevaan issueen.
- [ ] Työ on oikeassa branchissa.
- [ ] `git status` ei sisällä vahingossa lisättäviä tiedostoja.
- [ ] Commit-viesti kertoo, mitä tehtiin.
- [ ] Branch on pushattu GitHubiin.
- [ ] Pull request on avattu.
- [ ] Toinen pari on tehnyt katselmoinnin.
- [ ] Kommentit on käsitelty.
- [ ] Pull request on mergetty.
- [ ] Paikallinen `main` on päivitetty.

## 19. Koko esimerkki alusta loppuun

Esimerkissä toteutetaan issue #10:

```bash
git switch main
git pull origin main
git switch -c feature/issue-10-add-destination-form

# Tee muutokset editorissa
git status
git diff
git add .
git commit -m "Add destination form"
git push -u origin feature/issue-10-add-destination-form
```

Sen jälkeen:

1. Avaa pull request GitHubissa.
2. Lisää kuvaukseen `Closes #10`.
3. Pyydä pari katselmoijaksi.
4. Korjaa mahdolliset kommentit samassa branchissa.
5. Mergeä hyväksytty pull request.
6. Päivitä paikallinen main:

```bash
git switch main
git pull origin main
```

Muistakaa: commit tallentaa muutoksen paikallisesti, `git push` lähettää sen GitHubiin
ja pull request pyytää muutoksen yhdistämistä `main`-haaraan.
