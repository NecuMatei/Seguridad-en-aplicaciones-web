<?php
// Incluir el archivo de idioma
require("../../../lang/lang.php");
$strings = tr();

// Establecer la conexión a la base de datos con consultas preparadas
try {
    $db = new PDO('mysql:host=localhost;dbname=sql_injection', 'sql_injection', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Obtener el límite de imágenes
$stmt = $db->query("SELECT COUNT(*) FROM images");
$id_limit = $stmt->fetchColumn();

// Redirigir si el parámetro 'img' no está establecido o es inválido
if (!isset($_GET['img']) || !is_numeric($_GET['img']) || $_GET['img'] < 1 || $_GET['img'] > $id_limit) {
    header("Location: index.php?img=1");
    exit;
}

// Manejar las solicitudes POST para navegar entre imágenes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['next'])) {
        $next = $_GET['img'] + 1;
        if ($next > $id_limit) { 
            $next = 1;
        }
        header("Location: index.php?img=" . $next);
        exit;
    }
    if (isset($_POST['prev'])) {
        $prev = $_GET['img'] - 1;
        if ($prev < 1) {
            $prev = $id_limit;
        }
        header("Location: index.php?img=" . $prev);
        exit;
    }
}

// Obtener la imagen actual de la base de datos utilizando una consulta preparada
$stmt = $db->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$_GET['img']]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
    <div class="container">
        <div class="main">
            <div class="upper justify-content-center" style="text-align: center;margin: 2vh 0vh 6vh 0vh;">
                <h1>
                    <?php echo htmlspecialchars($strings['header']); ?>
                </h1>
                <form action="" method="POST" class="row justify-content-center" style="margin: 2vh 0vh 6vh 0vh;">
                    <div class="col-md-10 button-con row justify-content-evenly ">
                        <div class="bottom justify-content-center" style="text-align: center;">
                            <?php
                            // Mostrar la imagen si está definida y no hay errores
                            if (!empty($data)) {
                                echo '<img class="shadow bg-body rounded img-fluid" style="width:765px; height: 400px; object-fit: cover; padding : 0; margin-bottom: 0;" src="' . htmlspecialchars($data['path']) . '" alt="Image">';
                            }
                            ?>
                        </div>
                        <div class="btn-group w-75 mt-3">
                            <button class="btn btn-primary" type="submit" name="prev"><?php echo htmlspecialchars($strings['back']); ?></button>
                            <button class="btn btn-warning" type="submit" name="next"><?php echo htmlspecialchars($strings['next']); ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
