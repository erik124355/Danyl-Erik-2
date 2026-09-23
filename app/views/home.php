<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retkikohteet</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Retkikohteet</h1>

        <form id="spotForm">
            <input type="hidden" id="spotId">

            <input type="text" id="name" placeholder="Nimi" required>
            <input type="text" id="location" placeholder="Sijainti" required>
            <textarea id="description" placeholder="Kuvaus" required></textarea>

            <input type="number" id="latitude" placeholder="Leveysaste" step="any" min="-90" max="90" required>
            <input type="number" id="longitude" placeholder="Pituusaste" step="any" min="-180" max="180" required>

            <input type="text" id="type" placeholder="Tyyppi" required>
            <input type="text" id="difficulty" placeholder="Vaikeustaso" required>
            <input type="date" id="planned_date" required>

            <button id="submitButton" type="submit">Lisää retkikohde</button>
        </form>

        <div id="message" class="message"></div>

        <div id="spots" class="cards"></div>

<script src="/assets/app.js"></script>
    </div>

    <script>
        window.initialSpots = <?php echo json_encode($spots, JSON_UNESCAPED_UNICODE); ?>;
    </script>
</body>
</html>