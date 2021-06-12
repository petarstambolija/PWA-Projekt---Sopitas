<?php

include 'connect.php';

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>SOPITAS</title>
	
	<link rel='stylesheet' href='style.css'>
</head>
<body>

    <header>
		<div id='main_contents'>
			<img id='logo' src='images/logo.PNG' width='135px' height='66px'/>
		
			<nav>
				<ul>
					<li><a href='index.php'>Home</a></li>
					<li><a href='kategorija.php?kategorija=muzika'>Music</a></li>
					<li><a href='kategorija.php?kategorija=sport'>Sports</a></li>
					<li><a href='unos.php'>New News</a></li>
					<li><a href='administracija.php'>Administration</a></li>
				</ul>
			</nav>
		</div>
		
	</header>";
	
	$kategorija = $_GET['kategorija'];
		
	echo"
	<section id='$kategorija'>
		
		<div id='" . $kategorija . "_title'>
			<h2>" . $kategorija . "</h2>
		</div>
	
		<div class='contents'>";
		
		$query ="SELECT * FROM vijest WHERE arhiva=0 AND kategorija='$kategorija'";
		$result = mysqli_query($dbc, $query);
		
		while($row = mysqli_fetch_array($result)){
		
			echo"<article> 
				<div class='img_container'> <img class='preview' src='images/" . $row['slika'] . "'/> </div>
				<a href='clanak.php?id=" . $row['id'] . "class='text'>" . $row['naslov'] . "</a>
				<p class='date'>" . $row['datum'] . "</p>
				</article>";
		}
				
			
	echo"		
		</div>
	</section>
	
	<footer>
		<p> Petar Stambolija, 2021 </p>
	</footer>

</body>
</html>";


?>