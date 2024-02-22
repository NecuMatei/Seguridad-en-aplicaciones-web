<?php
require("../../../lang/lang.php");
$strings = tr();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user inputs
    $username = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
    $password = $_POST['passwd']; // No need to sanitize since we're hashing it

    if ($username && $password) {
        $db = new PDO('sqlite:database.db');
        $q = $db->prepare("SELECT id, username, password FROM users WHERE username=:user");
        $q->execute(['user' => $username]);
        $user = $q->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            header("Location: blind.php");
            exit;
        } else {
            // Implement generic error handling
            echo '<h1>Invalid username or password</h1>';
        }
    } else {
        // Implement validation error handling
        echo '<h1>Invalid input</h1>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?= htmlspecialchars($strings['title']); ?></title>
  </head>
  <body>
      <div class="container d-flex justify-content-center">
          <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
              <h4>VULNLAB</h4>

              <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
                  <div class="row mb-3">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" name="uname" id="inputEmail3" required>
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="inputPassword3" class="col-sm-2 col-form-label">Pass</label>
                      <div class="col-sm-10">
                          <input type="password" class="form-control" name="passwd" id="inputPassword3" required>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary"><?= htmlspecialchars($strings['submit']); ?></button>
                  <p>mandalorian / mandalorian </p>
              </form>
          </div>
      </div>
      <script id="VLBar" title="<?= htmlspecialchars($strings['title']); ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
  </body>
</html>