<?php
require("../../../lang/lang.php");
$strings = tr();

include_once('dependencies/dbConnect.php');

function safeEcho($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo $strings['kayit']; ?></title>
    <style>
        body {
            /* Estilos omitidos para mayor claridad */
        }
    </style>
</head>

<body>
    <!-- Se mantiene el contenido HTML, se ha eliminado el script de Bootstrap -->
    <?php
    // Eliminado código innecesario
    ?>

    <main>
        <div class="container" style="padding: 60px;">
            <h1 class="mt-4"><?php echo $strings['kayit']; ?></h1>

            <div class="row">
                <div class="col-4">
                    <!-- Se ha mejorado el formulario de búsqueda -->
                    <form method="GET">
                        <input type="text" placeholder="Search" value="<?php echo safeEcho($_GET['search'] ?? ''); ?>" name="search">
                        <button class="btn btn-primary" type="submit"><?php echo $strings['search']; ?></button>
                    </form>
                </div>
                <div class="col-8">
                    <form method="GET">
                        <button class="btn btn-primary" type="submit" style="margin-left:-90px"><?php echo $strings['reset']; ?></button>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <fieldset>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>E-Mail</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Se ha mejorado la consulta SQL utilizando prepared statements
                                $searchTerm = '%' . ($_GET['search'] ?? '') . '%';
                                $stmt = $mysqli->prepare("SELECT * FROM users WHERE name LIKE ?");
                                $stmt->bind_param("s", $searchTerm);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($list = $result->fetch_array()) {
                                    echo '
                                        <tr>
                                            <td>' . safeEcho($list['id']) . '</td>
                                            <td>' . safeEcho($list['username']) . '</td>
                                            <td>' . safeEcho($list['email']) . '</td>
                                            <td>' . safeEcho($list['name']) . '</td>
                                            <td>' . safeEcho($list['surname']) . '</td>
                                        </tr>
                                    ';
                                }

                                $stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </main>
</body>

</html>