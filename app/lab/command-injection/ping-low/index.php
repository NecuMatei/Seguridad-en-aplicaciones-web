<?php
require("../../../lang/lang.php");

$strings = tr();

function isSafeInput($input)
{
    // Validating input against a whitelist of allowed characters
    return preg_match('/^[a-zA-Z0-9.-]+$/', $input);
}

function sanitizeInput($input)
{
    // Sanitizing input to prevent code injection
    return filter_var($input, FILTER_SANITIZE_STRING);
}

?>

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title><?= htmlspecialchars($strings['title1']); ?></title>
		<link rel="stylesheet" href="./../bootstrap.min.css">
	</head>
	<body>
		<div class="container text-center">
			<div class="main-wrapper" style="margin-top: 25vh;">
				<div class="header-wrapper">
					<h2 class="col">PING</h2>
				</div>
				<div class="col-md-auto mt-3 d-flex justify-content-center">
					<form method="POST" class="flex-column">
						<input class="form-control" type="text" name="ip" style="width: 500px;" required>
						<button type="submit" class="btn btn-primary mt-4" style="width: 500px;">Ping</button>
					</form>
				</div>

				<div class="col-md-auto d-flex justify-content-center" style="">
					<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["ip"])) {
						$input = $_POST["ip"];

						if (isSafeInput($input)) {
							$input = sanitizeInput($input);

							echo "<br /><br />";

							exec("ping -c5 $input", $out);

							if (!empty($out)) {
								echo '<div class="mt-5 alert alert-primary" role="alert" style="width: 500px;"> <strong><p style="text-align:center;">';
								foreach ($out as $line) {
									echo htmlspecialchars($line) . "<br>";
								}
								echo ' </p></strong></div>';
							}
						} else {
							echo '<div class="mt-5 alert alert-danger" role="alert" style="width: 500px;"> <strong><p style="text-align:center;">Invalid input</p></strong></div>';
						}
					}
					?>
				</div>
			</div>
		</div>
		<script id="VLBar" title="<?= htmlspecialchars($strings['title1']) ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
	</body>
</html>
