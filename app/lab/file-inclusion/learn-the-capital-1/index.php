<?php 
    // Desactiva la notificación de errores para ocultar posibles problemas.
    error_reporting(0);
    
    // Incluye el archivo de traducción desde una ubicación relativa.
    require("../../../lang/lang.php");
    
    // Asigna el resultado de la función tr() a la variable $strings.
    $strings = tr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <!-- Título de la página obtenido de las traducciones -->
    <title><?php echo htmlspecialchars($strings['title']); ?></title>
    <style>
        p{
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5">
                <!-- Formulario de selección de país -->
                <div class="col-md-6">
                    <form action="index.php" method="GET">
                        <div class="mb-3">
                            <!-- Etiqueta del formulario obtenida de las traducciones -->
                            <label for="country" class="form-label"><?php echo htmlspecialchars($strings['label']); ?></label>
                            <select name="country" id="country" class="form-select">
                                <!-- Opciones del formulario obtenidas de las traducciones -->
                                <option value="france.php"><?php echo htmlspecialchars($strings['paris']); ?></option>
                                <option value="germany.php"><?php echo htmlspecialchars($strings['berlin']); ?></option>
                                <option value="north_korea.php"><?php echo htmlspecialchars($strings['pyongyang']); ?></option>
                                <option value="turkey.php"><?php echo htmlspecialchars($strings['ankara']); ?></option>
                                <option value="england.php"><?php echo htmlspecialchars($strings['london']); ?></option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <!-- Texto del botón obtenido de las traducciones -->
                            <button class="btn btn-primary" type="submit"><?php echo htmlspecialchars($strings['button']); ?></button>
                        </div>
                    </form>
                </div>
                <!-- Sección para mostrar el contenido seleccionado -->
                <div class="col-md-6">
                    <div class="mb-3">
                    <p><?php 
                        // Verifica si el parámetro 'country' está presente en la URL.
                        if(isset($_GET['country'])){
                            // Define un array con los nombres de archivo permitidos.
                            $allowed_files = array("france.php", "germany.php", "north_korea.php", "turkey.php", "england.php");
                            // Obtiene el nombre de archivo especificado por el usuario.
                            $page = $_GET['country'];
                            
                            // Verifica si el nombre de archivo especificado está en la lista de archivos permitidos
                            // y si el archivo realmente existe en el sistema.
                            if (in_array($page, $allowed_files) && file_exists($page)) {
                                // Si el archivo es permitido y existe, lo incluye en la página.
                                include($page);
                            } else {
                                // Si el archivo no es permitido o no se encuentra, muestra un mensaje de error.
                                echo "Archivo no permitido o no encontrado.";
                            }
                        }
                    ?>
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="6" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>