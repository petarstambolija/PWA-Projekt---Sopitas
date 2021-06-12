<?php

include 'connect.php';

echo"<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>SOPITAS</title>
	
	<link rel='stylesheet' href='style.css'>
</head>
<body>

    <header>
		<div id='news_contents'>
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
		
	</header>
	
	<section id='news'>";
	
	
	$id = $_GET['id'];
		
	$query ="SELECT * FROM vijest WHERE id='$id'";
	$result = mysqli_query($dbc, $query);
		
	while($row = mysqli_fetch_array($result)){
		
		echo"
		<img id='preview' src='images/" . $row['slika'] . "'/>
		<h1>" . $row['naslov'] . "</h1>
		<p id='date'>" . $row['datum'] . "</p>
		<p id ='sadrzaj'>" . $row['sazetak'] . "</p>
		<p id ='text'>" . $row['tekst'] . "</p>";
	}
	
	mysqli_close($dbc);
		
	echo"
	</section>
	
	<footer>
		<p> Petar Stambolija, 2021 </p>
	</footer>

</body>
</html>";

?>