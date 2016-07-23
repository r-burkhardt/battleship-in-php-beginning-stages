<?php
	// Start the session
	session_start();
						
	function createPassword($length)
	{
	    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
	    srand((double)microtime()*1000000);
	    $i = 0;
	    $pass = '' ;
	
	    while ($i <= ($length - 1)) {
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass = $pass . $tmp;
	        $i++;
	    }
	    return $pass;
	}
	
	function shipSunk($rowTest)
	{
		$bombCount = 0;
		for($col = 0; $col <15; $col++)
		{
			if($_SESSION['bombs'][$rowTest][$col] == 9)
			{
				$bombCount++;
			}
		}
		
		if($bombCount == $_SESSION['shipSizeRow'][$rowTest])
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	if(!array_key_exists('postID',$_SESSION))
	{
		$_SESSION['postID'] = createPassword(32);
	}

	if(!empty($_POST))
	{
		
		if(($_SESSION['postID'] != $_POST['post_id']))
		{
			$_SESSION['postID'] = $_POST['post_id'];
			
			$_rowSelect = $_POST['rowSelect'];
			$_colSelect = $_POST['colSelect'];
			
			if($_SESSION['ships'][$_rowSelect][$_colSelect] != 0) 
			{
				$_SESSION['bombs'][$_rowSelect][$_colSelect] = 9;
				if(shipSunk($_rowSelect))
				{
					$_SESSION['sunkCount']++;
					if($_SESSION['sunkCount'] < 5) 
					{
						$msg = "<span id=\"sunk\">You've Sunk A Battleship!</span>";
					}
					else 
					{
						$msg = "<span id=\"sunk\">You Defeated the Enemy!</span>";
					}
				}
				else 
				{
					$msg = "Direct Hit! Make your next Play!";
				}
			}
			else 
			{
				$_SESSION['bombs'][$_rowSelect][$_colSelect] = 8;
				$msg = "You missed! Make your next Play!";
			}
			unset($_POST);
		}
		else 
		{
			$msg = "Select your next play.";
		}
		
	}
	else 
	{
		$msg = "Click on a square to select your point of fire.";
	}

?>

<!DOCTYPE html>

<html>

	<head>
	
		<meta charset="utf-8" />
		
		<title>Assignment 2 - CST 336</title>
		
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
	
					<?php
						
						/*function createPassword($length)
						{
						    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
						    srand((double)microtime()*1000000);
						    $i = 0;
						    $pass = '' ;
						
						    while ($i <= ($length - 1)) {
						        $num = rand() % 33;
						        $tmp = substr($chars, $num, 1);
						        $pass = $pass . $tmp;
						        $i++;
						    }
						    return $pass;
						}*/
									
						echo "<h3 id=\"message\">" . $msg . "</h3>";
						echo "<table id=\"game\">";
							
							
						//Program to produce table
						if($_SESSION['sunkCount'] < 5)
						{
							for($r = 0; $r < 15; $r++)
							{
								echo "<tr>";
								
								for($c = 0; $c < 15; $c++)
								{
									
									if($_SESSION['bombs'][$r][$c] == 0)
									{
										echo "<td class = \"ocean\">";
										echo "<form class=\"grid\" method=\"post\" >";
										echo "<input type=\"hidden\" name=\"post_id\" value=\"" . createPassword(32) . "\" />";
										echo "<input type=\"hidden\" name=\"rowSelect\" value=\"" . $r .  "\" />";
										echo "<input type=\"hidden\" name=\"colSelect\" value=\"" . $c . "\" />";
										echo "<input type=\"submit\" value=\"*\" />";
										echo "</form>";
										echo "</td>";
									}
									elseif($_SESSION['bombs'][$r][$c] == 8)
									{
										echo "<td class = \"missed\">&nbsp;</td>";
									}
									elseif($_SESSION['bombs'][$r][$c] == 9)
									{
										echo "<td class = \"hit\">&nbsp;</td>";
									}
								}
								
								echo "</tr>";
							}
						}
						else 
						{
							for($r = 0; $r < 15; $r++)
							{
								echo "<tr>";
								
								for($c = 0; $c < 15; $c++)
								{
									
									if($_SESSION['bombs'][$r][$c] == 0)
									{
										echo "<td class = \"ocean-go\">&nbsp;</td>";
									}
									elseif($_SESSION['bombs'][$r][$c] == 8)
									{
										echo "<td class = \"missed-go\">&nbsp;</td>";
									}
									elseif($_SESSION['bombs'][$r][$c] == 9)
									{
										echo "<td class = \"hit-go\">&nbsp;</td>";
									}
								}
								
								echo "</tr>";
							}
						}
						
						echo "</table>";
						//echo "<p>Click on the squares to select the area you desire to fire at.</p>";
								
						echo "<br />";
						
						// Make a new game
						echo "<form id=\"new-game\" action=\"index.php\">";
						echo "<input type=\"submit\" name=\"play\" value=\"New Game\" />";
						echo "</form>";
						
						echo "<br />";
						
						/*echo "<table id=\"testing\">";
						
							for($tr = 0; $tr < 15; $tr++)
							{
								echo "<tr>";
								
								for($tc = 0; $tc < 15; $tc++)
								{
									echo "<td>". $_SESSION['ships'][$tr][$tc] . "</td>";
								}
								
								echo "</tr>";
								
							}
						
						echo "</table>";*/
					
					?>

				</main>
			
			</div>
		
		</div>
		
		<footer>
			
			&copy; MMVI - Roderick Burkhardt
		
		</footer>
		
	</body>

</html>