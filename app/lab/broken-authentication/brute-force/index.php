<?php
require("../../../lang/lang.php");
$strings = tr();
require("brute.php");


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= $strings["title"]; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= $strings["login"]; ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= $strings["username"]; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= $strings["password"]; ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= $strings["submit"]; ?></button>
                <p class="mt-3"><?= $strings["hint"]; ?></p>
                <?php
                echo '<h1> '.$html.' </h1>'; 
                //build throttle settings array. (# recent failed logins => response).

                $throttle_settings = [

                    50 => 2,            //delay in seconds
                    150 => 4,           //delay in seconds
                    300 => 'captcha'    //captcha 
            ];


            $BFBresponse = BruteForceBlocker::getLoginStatus($throttle_settings); 

            //$throttle_settings is an optional parameter. if it's not included,the default settings array in BruteForceBlocker.php will be used

            switch ($BFBresponse['status']){

            case 'safe':
                    //safe to login
                    break;
                case 'error':
                    //error occured. get message
                    $error_message = $BFBresponse['message'];
                    break;
                case 'delay':
                    //time delay required before next login
                    $remaining_delay_in_seconds = $BFBresponse['message'];
                    break;
                case 'captcha':
                    //captcha required
                    break;

            }
                ?>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>


</body>

</html>