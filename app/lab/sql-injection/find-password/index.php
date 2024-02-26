<?php
require("../../../lang/lang.php");
require('dependencies/dbConnect.php'); // Asegúrate de que este archivo maneje la conexión de forma segura

$strings = tr();

// Evita la inyección de SQL usando sentencias preparadas
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt = $mysqli->prepare("SELECT id, username, email, name, surname FROM users WHERE name LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    // Si no hay término de búsqueda, realiza una consulta sin filtrar
    $query = $mysqli->query("SELECT id, username, email, name, surname FROM users");
    if ($query) {
        $result = $query->fetch_all(MYSQLI_ASSOC);
    } else {
        // Manejo de errores si la consulta falla
        die("Error en la consulta: " . $mysqli->error);
    }
}

// Escapa los datos de salida para prevenir ataques XSS
function escapeHtml($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title> <?php echo $strings['kayit'] ?> </title>
    <style>
      body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
      }
    </style>
  </head>
  <body>
    <script id="VLBar" title="<?= $strings['kayit'] ?>" category-id="2" src="/public/assets/js/vlnav.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <?php


    if(isset($_REQUEST['delete']) and $_REQUEST['delete'] == 1)
    {
        if(isset($_REQUEST['search']))
        {
            unset($_REQUEST['search']);
        }
    }
    include('dependencies/dbConnect.php');   

    global $mysqli;

?> 
    <main>
      <div class="container-fluid" style="padding: 60px;">
        <div class="container-fluid">
          <h1 class="mt-4"><?= escapeHtml($strings['kayit']) ?></h1>
        
    <div class="form-group">
      <span></span>
    </div>
    <div class="row">
      <div class="col-4">
        <form method="GET">
          <input type="text" placeholder="Search" value="<?= isset($_GET['search']) ? escapeHtml($_GET['search']) : '' ?>" name="search">
          <button class="btn btn-primary" type="submit"><?= escapeHtml($strings['search']) ?></button>
        </form>
      </div>
      <div class="col-8">
        <form method="GET">
          <button class="btn btn-primary" type="submit" style="margin-left:-90px"><?= escapeHtml($strings['reset']) ?></button>         
          <!-- <input placeholder="Delete" style="display:none" value="1" name="delete"> -->
        </form>
      </div>
    </div>
    <div class="">
      <fieldset>
        <div class="form-group">
          <div class="">
            <div class="table-responsive mt-4">
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

                    if(isset($_GET['search']) and $_GET['search'] != "" )
                    {
                      $query = $mysqli->query("SELECT * FROM users WHERE 
                      name LIKE '%" . $_GET['search'] . "%'");
                      while($list = $query->fetch_array())
                      {
                        echo '
                                                    
													<tr>
														<td>'.$list['id'].'</td>
														<td>'.$list['username'].'</td>
														<td>'.$list['email'].'</td>
														<td>'.$list['name'].'</td>
                            <td>'.$list['surname'].'</td>       
													</tr>
                          ';
                      }
                    }else{
                      $query = $mysqli->query("SELECT * FROM users ");
                      while($list = $query->fetch_array())
                      {
                        echo '
                           <tr>
                              <td>'.$list['id'].'</td>
                              <td>'.$list['username'].'</td>
                              <td>'.$list['email'].'</td>
                              <td>'.$list['name'].'</td>
                              <td>'.$list['surname'].'</td>   
													 </tr>
                            ';
                      }
                                                
                      }
                  ?> 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </fieldset>
    </div>
    </div>
 
    </main>
  </body>
</html>