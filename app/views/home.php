
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
            <input type="text" id="name" placeholder="Nimi" required>
            <input type="text" id="location" placeholder="Sijainti" required>
            <textarea id="description" placeholder="Kuvaus"></textarea>
            <button type="submit">Lisää retkikohde</button>
        </form>

        <div id="message" class="message"></div>

        <div id="spots" class="cards"></div>
    </div>

    <script>
        const spotsData = <?php echo json_encode($spots, JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script src="/assets/app.js"></script>
</body>
</html>