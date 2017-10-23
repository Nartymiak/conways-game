<?php
/**
 * Conways game of life
 * PHP version 5.2.9
 *
 * @author  Nick Artymiak
**/


  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  include_once('game.php');

  /**
  * change the file path here
  **/
  $filepath = 'board3.txt';

  $game = new Game($filepath);
?>

<html>
		<head>
			<!-- datto - Conway’s Game of Life - version 0-->
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name=viewport content="width=device-width, initial-scale=1">
			<meta http-equiv="cache-control" content="max-age=0" />
			<meta http-equiv="cache-control" content="no-cache" />
			<meta http-equiv="expires" content="0" />
			<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
			<meta http-equiv="pragma" content="no-cache" />
			<title>Conways Game of Life - Nick Artymiak Version</title>
		</head>

		<body>
<?php
        // start the game, activate the turn and print
        $game->startGame();
        $game->stepGameTurn();

?>
    </body>
</html>
