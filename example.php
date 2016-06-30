<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();

function flash($class, $message) {
	$sess = '<div class="message message-' . $class . '"><p>' . $message . '</p></div>';
	$_SESSION['flash'] = $sess;
}

$word = filter_input(INPUT_POST, 'word', FILTER_DEFAULT);

if ( !is_null($word) ):
	if ( Badwords\Badwords::verify($word) ):
		flash('danger', 'Palavra inapropriada');
	else:
		flash('success', 'Palavra apropriada');
	endif;
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet" type="text/css">

		<title>Badwords Exemplo</title>

		<style>
			* { margin: 0; padding: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
			body { font-family: 'Roboto Condensed'; font-size: 1.2em; font-weight: 300; background: #eee; }
			.container { text-align: center; margin-top: 6em; }
			.form-container { width: 100%; max-width: 600px; margin: auto; }
			.message { width: 100%; padding: 1em; margin: 1em 0; border-radius: 3px; }
			.message.message-success { background: #dff0d8; color: #3c763d; border: 1px solid #d0e9c6; }
			.message.message-danger { background: #f2dede; color: #a94442; border: 1px solid #ebcccc; }
			input { display: block; width: 70%; margin: .5em auto; line-height: 2; font-size: 1em; font-family: 'Roboto Condensed'; border: 1px solid #ccc; border-radius: 3px; outline: none; padding: 0 .5em; }
			button { line-height: 2.2; margin-top: 1em; padding: 0 2em; font-size: 1em; border-radius: 3px; outline: none; color: #eee; background: #666; border: 1px solid #777; cursor: pointer; }
			button:hover { background: #444; }
			h1 { margin: 1em; color: tomato; }
		</style>
	</head>
	<body>
		<div class="container">
			<h1>Badwords Exemplo</h1>

			<div class="form-container">

				<?php
					if ( isset($_SESSION['flash']) ):
						echo $_SESSION['flash'];
						unset($_SESSION['flash']);
					endif;
				?>

				<form action="" method="post">
					<label for="word">Palavra para filtar:</label>
					<input type="text" name="word" id="word">

					<button type="submit">Verificar</button>
				</form>
			</div><!-- /.form-container -->
		</div><!-- /.container -->
	</body>
</html>