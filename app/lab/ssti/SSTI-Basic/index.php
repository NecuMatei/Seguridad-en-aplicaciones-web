<?php
require("../../../lang/lang.php");
$strings = tr();

try {
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

// Al enviar el formulario (cuando se hace clic en el botón "submit")
if (isset($_POST['submit'])) {
    // Se obtiene el contenido del campo de texto del blog desde el formulario
    $userInput = strip_tags($_POST["content"]); // Eliminar etiquetas HTML del contenido

    // Se prepara la consulta SQL para insertar el contenido en la base de datos de manera segura
    $query = "INSERT INTO blog_entries (content) VALUES (:content)";
    $stmt = $db->prepare($query);

    // Se vincula el valor del contenido al parámetro de la consulta preparada
    $stmt->bindParam(':content', $userInput, PDO::PARAM_STR);

    // Se ejecuta la consulta preparada para insertar el contenido en la base de datos
    $stmt->execute();
}

$query = "SELECT * FROM blog_entries ORDER BY id DESC ";
$stmt = $db->prepare($query);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container" style="padding-top:5%;">
        <h1 class="mb-2 text-center"><?php echo $strings['welcome']; ?></h1><br>
        <form method="POST" class="text-center">
            <div class="mb-2">
                <label for="content" class="form-label"><?php echo $strings['blog_post']; ?></label>
                <textarea class="form-control" id="content" name="content" rows="6" placeholder="<?php echo $strings['who']; ?>" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit"><?php echo $strings['submit']; ?></button>
        </form><br>

        <h2 class="mt-2 text-center"><?php echo $strings['latest_entries']; ?></h2>
        <div id="blogEntries" class="row">
            <?php foreach ($entries as $entry): ?>
                <div class="col-md-12 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Se utiliza htmlspecialchars para escapar el contenido al renderizarlo en la página -->
                            <p class="card-text"><?php echo htmlspecialchars($entry['content']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="12" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>