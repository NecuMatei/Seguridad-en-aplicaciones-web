<?php

require_once("../../../lang/lang.php");

// Manejo de la conexión a la base de datos utilizando PDO
try {
    $db = new PDO('mysql:host=localhost; dbname=sql_injection', 'sql_injection', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

$strings = tr();
$result = "";

// Manejo del formulario enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? '';

    try {
        // Utilizar sentencia preparada para prevenir SQL injection
        $stmt = $db->prepare("SELECT * FROM stocks WHERE name = :search");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $list = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron resultados
        $result = (!empty($list['name'])) ? "true" : "false";
    } catch (PDOException $e) {
        // Manejar errores de consulta SQL
        die("Error en la consulta: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $strings['title'] ?></title>
        <link rel="stylesheet" href="bootstrap.min.css">
    </head>
    <body>
        <div class="container d-flex justify-content-center flex-column">
            <div class="header-wrapper d-flex justify-content-center" style="margin-top: 20vh;">
                <h1><?= $strings['header'] ?></h1>
            </div>
            <div class="body-wapper d-flex justify-content-center mt-5">
                <form action="#" method="POST">
                    <div class="mt-3 fs-5" style="margin-left: 2px;"><?= $strings['text'] ?></div>
                    <select class="form-select form-select-lg mt-2" name="search" style="width: 500px;" id="opt">
                        <option selected><?= $strings['selected'] ?></option>
                        <option value="iphone11"><?= $strings['select1'] ?></option>

                        <option value="airpodspro"><?=$strings['select2'] ?></option>
                        <option value="applewatch7"><?=$strings['select3'] ?></option>
                        <option value="iphone6s"><?=$strings['select4'] ?></option>
                        <option value="iphone13"><?=$strings['select5'] ?></option>
                        <option value="apple20w"><?=$strings['select6'] ?></option>
                        <option value="ipad9"><?=$strings['select7'] ?></option>
                        <option value="iphonese"><?=$strings['select8'] ?></option>
                    </select>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning mt-5 "><?= $strings['check'] ?></button>
                    </div>
                </form>
            </div>

            <?php
            if (!empty($result)) {
                if ($result == "true") {
                    echo '<div class="alert-div d-flex justify-content-center mt-5">
                            <div class="alert alert-success text-center" style="width: 500px;" role="alert">';
                    echo $strings['success'];
                    echo '</div>
                        </div>';
                } else {
                    echo '<div class="alert-div d-flex justify-content-center mt-5">
                            <div class="alert alert-danger text-center" style="width: 500px;" role="alert">';
                        
                    echo $strings['failed'];
                    echo '</div>
                        </div>';
                }
            }
            ?>
        </div>
        <script id="VLBar" title="<?= $strings['title'] ?>" category-id="2" src="/public/assets/js/vlnav.min.js"></script>
    </body>
</html>