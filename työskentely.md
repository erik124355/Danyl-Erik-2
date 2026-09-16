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
- Node.js:n ja NPM:n
- koodieditorin, esimerkiksi Visual Studio Coden
- GitHub-tunnuksen

Tarkistakaa asennukset:

```bash
git --version
node --version
npm --version
```

Jos jokin komento ei toimi, pyytäkää opettajalta apua ennen työskentelyn jatkamista.

## 3. Repositoryn lataaminen ensimmäisellä kerralla

Valitkaa tietokoneelta kansio, johon projekti tallennetaan. Suorittakaa komennot siinä kansiossa:

```bash
git clone https://github.com/Savo-Consortium-of-Education/tiimi.git
cd tiimi
npm install
```

`git clone` lataa projektin omalle tietokoneelle. `cd tiimi` siirtyy projektikansioon.
`npm install` asentaa projektin riippuvuudet.

## 4. Ennen uuden tehtävän aloittamista

Päivittäkää paikallinen `main`-haara ennen uuden branchin luomista:

```bash
git switch main
git pull origin main
```

Valitkaa työ GitHubin avoimista issueista. Lukekaa issuen tehtävä ja hyväksymiskriteerit
ennen kuin aloitatte koodaamisen.

## 5. Branchin luominen

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
git switch -c feature/issue-03-sqlite-setup
git switch -c fix/issue-18-validation-errors
git switch -c docs/issue-20-readme
```

## 6. Muutosten tekeminen

Toteuttakaa vain valittuun issueen kuuluva työ. Testatkaa sovellusta muutosten aikana.

Tarkistakaa projektin tila:

```bash
git status
```

Tarkistakaa, mitä koodissa muuttui:

```bash
git diff
```

Älkää lisätkö salasanoja, API-avaimia, `node_modules`-kansiota tai tietokantatiedostoja
committiin, ellei projektin ohjeissa erikseen sanota niin.

## 7. Commitin tekeminen

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

## 8. Branchin pushaminen GitHubiin

Kun työ on commitissa, pushatkaa branch GitHubiin:

```bash
git push -u origin feature/issue-10-add-destination-form
```

Ensimmäinen push tarvitsee `-u`-option. Sen jälkeen riittää:

```bash
git push
```

## 9. Pull requestin avaaminen

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

## 10. Toisen parin tekemä katselmointi

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

## 11. Pull requestin kommenttien korjaaminen

Pysykää omassa branchissa ja tehkää korjaukset siellä:

```bash
git status
git add .
git commit -m "Address review feedback"
git push
```

Uutta pull requestia ei tarvitse avata. Uusi push päivittyy samaan pull requestiin.

## 12. Pull requestin mergeäminen

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

## 13. Seuraavan issuen aloittaminen

Aloittakaa aina päivitetystä `main`-haarasta:

```bash
git switch main
git pull origin main
git switch -c feature/issue-11-destination-listing
```

Älkää luoko uutta branchia vanhan työbranchin pohjalta, jos tehtävät eivät kuulu samaan
pull requestiin.

## 14. Jos Git ilmoittaa merge-konfliktista

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

## 15. Hyödylliset tarkistuskomennot

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

## 16. Tyypillisiä ongelmia

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

## 17. Päivän lopun tarkistuslista

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

## 18. Koko esimerkki alusta loppuun

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
