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
		<div id='news_contents'>
			<img id='logo' src='images/logo.PNG' width='135px' height='66px'/>
		
			<nav>
				<ul>
					<li><a href='index.php'>Home</a></li>
					<li><a href='kategorija.php?kategorija=muzika'>Music</a></li>
					<li><a href='kategorija.php?kategorija=sport'>Sports</a></li>
					<li><a href='unos.php'>New News</a></li>
					<li><a href=''>Administration</a></li>
				</ul>
			</nav>
		</div>
		
	</header>";
	
	
	
	if(isset($_POST['submit'])){
		
		$slika = $_FILES['slika']['name'];
		$naslov = $_POST['naslov'];
		$sazetak = $_POST['sadrzaj'];
		$text = $_POST['text'];
		$kategorija = $_POST['kategorija'];
		$datum = date('M d Y');
		$arhiva = isset($_POST['arhiva']) ? 1 : 0;
		
		$target_dir = 'images/' . $slika;
		move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);
		
		$querry="INSERT INTO vijest (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) values (?, ?, ?, ?, ?, ?, ?)";

		$stmt=mysqli_stmt_init($dbc);
		$success = false;
	
		if (mysqli_stmt_prepare($stmt, $querry)){

			mysqli_stmt_bind_param($stmt,'ssssssi', $datum, $naslov, $sazetak, $text, $slika, $kategorija, $arhiva);

			$success = mysqli_stmt_execute($stmt);
		} 
		
		mysqli_close($dbc);
	
		
		echo "
		<section id='news'>
		
		<img id='preview' src='images/$slika'/>
		<h1> $naslov </h1>
		<p id='date'> $datum </p>
		<p id='sadrzaj'> $sazetak </p>
		<p id ='text'> $text </p>
		
		</section>
		
		<footer>
			<p> Petar Stambolija, 2021 </p>
		</footer>

		</body>
		</html>";
	}
	

?>