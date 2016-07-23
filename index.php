<?php
	// Start the session
	//session_start();
	
	if(session_id() == '') {
    session_start();
    $_SESSION['newGame'] = true;
	}
	
	if($_SESSION['newGame'] == true)
	{	
				
		$_shipSizes = array(2,3,3,4,5);
		$_ships = array
						(
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
						);
		$_shipSizeRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		$_bombs = array
						(
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
							array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
						);
		$_sunkCount = 0;
		
		$_SESSION['shipSizes'] = $_shipSizes;
		$_SESSION['ships'] = $_ships;
		$_SESSION['shipSizeRow'] = $_shipSizeRow;
		$_SESSION['bombs'] = $_bombs;
		$_SESSION['sunkCount'] = $_sunkCount;
		
		$rowUsed = array();
					
		function getRand()
		{
			global $rowUsed;
			$goodNum = false;
			$randNum = 0;
			
			do 
			{
				$randNum = rand(0, 224);
				$test = intval($randNum/15);
				if(in_array($test, $rowUsed))
				{
					$goodNum = false;
				}
				else 
				{
					array_push(&$rowUsed, $test);
					$goodNum = true;
				}
			} while(!$goodNum);
	
			return $randNum;
		}
			
		function setShips()
		{
			$_SESSION['shipSizes'];
			$_SESSION['ships'];
			global $rowUsed;
			
			foreach ($_SESSION['shipSizes'] as $ship)
			{
				$randPosition = getRand();
				$row = intval($randPosition / 15);
				$col = 0;
				$colTest = $randPosition % 15;
				
				if((15 - $colTest) < $ship)
				{
					//echo "too small for ship<br />";
					$col = ($randPosition % 15) - $ship;
				}
				else 
				{
					$col = $randPosition % 15;
				}
				
				for($j = $col; $j < ($col + $ship); $j++)
				{
					$_SESSION['ships'][$row][$j] = $ship;
				}
				
				$_SESSION['shipSizeRow'][$row] = $ship;
				
				//echo "ship size is " . $ship . " <br />";
				//echo "rand is " . $randPosition . "<br />";
				//echo "row is " . $row . "<br />";
				//echo "col is " . $col . "<br />";
				//echo "<br />";
				
				$_SESSION['newGame'] = false;
				
			}
		}
		
		setShips();

	}

?>

<!DOCTYPE html>

<html>

	<head>
	
		<meta charset="utf-8" />
		
		<title>Lab2 - CST 336</title>
		
		<link href="https://fonts.googleapis.com/css?family=Teko:700" rel="stylesheet">
		
		<link href="./css/main.css" type="text/css" rel="stylesheet" />
	
	</head>
	
	<body>
	
		<div id="wrapper">
			
			<div id="inner-wrapper">
			
				<header>
				
					<h1 id="title-heading">BATTLESHIP</h1>
				
				</header>
				
				<main>
				
					<img id="title-image" src="./images/battleship.jpg" alt="">
					
					<br />
					<br />
					
					<form id="new-game" action="play.php">
					
						<input type="submit" name="play" value="Play" />
					
					</form>
					
					<br />
					<br />
				
				</main>
			
			</div>
			
		</div>
		
		<footer>
			
			&copy; MMVI - Roderick Burkhardt
		
		</footer>
	
	</body>

</html>