<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php
class Game {
	var $position;
	var $newposition;
	function __construct($squares)
	{
		$this->position = str_split($squares);
	}
	function winner($token) {
		$result = false;
		for($row=0; $row<3; $row++) {
			if (($this->position[3 * $row] == $token) && ($this->position[3 * $row + 1] == $token) &&
				($this->position[3 * $row + 2] == $token)) {
				$result = true;
			}
		}
		for($col=0; $col < 3; $col++) {
			if (($this->position[$col] == $token) &&
				($this->position[3 + $col] == $token) &&
				($this->position[6 + $col] == $token)) {
				$result = true;
			}
		}
		if (($this->position[0] == $token) &&
			($this->position[4] == $token) &&
			($this->position[8] == $token)) {
			return true;
		}
		if (($this->position[2] == $token) &&
			($this->position[4] == $token) &&
			($this->position[0] == $token)) {
			return true;
		}
		return $result;
	}
	function display() {
		echo '<table style="font-size:large; font-weight:bold">';
		echo '<tr>';
		for ($pos=0; $pos<9;$pos++) {
			echo $this->show_cell($pos);
			if ($pos %3 == 2) echo '</tr><tr>';
		}
		echo '</tr>';
		echo '</table>';
	}
	function show_cell($which) {
		$token = $this->position[$which];
		if ($token <> '-')
			return '<td>'.$token.'</td>';
		// now the hard case
		$this->newposition = $this->position;
		$this->newposition[$which] = 'o';
		$move = implode($this->newposition); //
		$link = '?board='.$move;
		return '<td><a href="'.$link.'">-</a></td>';
	}
	function pick_move() {
		for($pos=0; $pos<9; $pos++) {
			if($this->position[$pos] == '-') {
				$this->position[$pos] = 'x';
				break;
			}
		}
	}
}
if(isset($_GET['board'])) {
	$squares = $_GET['board'];
	$game = new Game($squares);
	if ($game->winner('x'))
		echo 'You win. Lucky guesses!';
	else if ($game->winner('o'))
		echo 'I win. Muahahahaha';
		else
	{
		$game->pick_move();
		echo 'No winner yet, but you are losing.';
	}
	$game->display();
} else {
	echo "Welcome to George, the evil Tic-Tac-Toe Game.";
	$squares = "---------";
	$game = new Game($squares);
	$game->display();
}
		?>
	</body>
</html>