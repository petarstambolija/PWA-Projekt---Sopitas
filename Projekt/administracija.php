<?php

include 'connect.php';
session_start();

$prijavljenKorisnik = false;
$admin = false;

echo"
<!DOCTYPE html>
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
	<br/><br/>";


if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$lozinka = $_POST['password'];

	$query="SELECT username, password, level FROM korisnik WHERE username=?";

	$stmt=mysqli_stmt_init($dbc);
	$success = false;
	
	if (mysqli_stmt_prepare($stmt, $query)){

		mysqli_stmt_bind_param($stmt,'s', $username);
		$success = mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
	} 
	
	mysqli_stmt_bind_result($stmt, $user, $pass, $level);
	mysqli_stmt_fetch($stmt);
	
	
	if (mysqli_stmt_num_rows($stmt) > 0) {
		
		if(password_verify($lozinka, $pass)) {
			
			$prijavljenKorisnik = true;
			$_SESSION['username'] = $user;
			$_SESSION['level'] = $level;
			
			if($level == 1){
				$admin = true;
			}
			
		} else {
			echo "<div class='infotext'> Neispravno ime ili lozinka. <br/>
			Ako nemate račun, možete se registrirati ovdje: <a href='registracija.php'> REGISTRACIJA </a> </div>";
		}
	}
	else {
		echo "<div class='infotext'> Neispravno ime ili lozinka. <br/>
			Ako nemate račun, možete se registrirati ovdje: <a href='registracija.php'> REGISTRACIJA </a> </div>";
	}
} else {
	
	if ((isset($_SESSION['username'])) == false || isset($_POST['odjava'])){
		
		$_SESSION['username'] = null;
		$_SESSION['level'] = "";
		$prijavljenKorisnik = false;
		$admin = false;
		
		echo"
			<section id='forma'>
			
				<form method='post' action='administracija.php'>
						
					Korisničko ime:
					<br/>
					<input name='username' id='username' type='text'/>
					<br/>
					Lozinka:
					<br/>
					<input name='password' id='password' type='password'/>
					<br/>
					<input name='submit' id='submit' type='submit' value='Prijavi se!'/>
				
				</form>
			</section>";
	}
	
}

if(($prijavljenKorisnik && $admin) || (isset($_SESSION['username']) && $_SESSION['level'] == 1)){
	echo"
	<div class='infotext'> 
			<p> Pozdrav ". $_SESSION['username'] . ". Uspješno ste prijavljeni.</p>
			<p> Vi ste administrator! </p>
			<form method='post' action='administracija.php'>
				<input type='submit' name='odjava' value='Odjava'/>
			</form>
		 </div>
		 
		 <br><br>
	
	<section id='forma'>";
		
		$query ="SELECT * FROM vijest";
		$result = mysqli_query($dbc, $query);
		
		while($row = mysqli_fetch_array($result)){
		
		echo "
			<form enctype='multipart/form-data' method='post' action='administracija.php'>
			
				Naslov:
				<br>
				<input name='naslov' id='naslov' type='text' value='" . $row['naslov'] . "' />
				<br/>
				Kratki sadržaj vjesti (do 100 znakova):
				<br/>
				<textarea name='sadrzaj' id='sadrzaj' value=> " . $row['sazetak'] . " </textarea>
				<br>
				Sadržaj vjesti:
				<br/>
				<textarea name='text' id='text'> " . $row['tekst'] . " </textarea>
				<br>
				Photo:
				<br/>
				<input name='slika' id='slika' type='file' value=images/".$row['slika']."/>
				<br/>
				<img src='images/" . $row['slika'] . "' width=100px/>
				<br/>
				Kategorija:
				<br>
				<select name='kategorija'>";
					if($row['kategorija'] == 'Sport') echo "<option value='Sport' selected='selected'> Sport </option>";
					else echo "<option value='Sport'> Sport </option>";
					
					if($row['kategorija'] == 'Muzika') echo "<option value='Muzika' selected='selected'> Muzika </option>";
					else echo "<option value='Muzika'> Muzika </option>";
				echo"	
				</select>
				<br>
				<div id='arhiva'>
					<label> Spremiti u arhivu?:";
					if($row['arhiva'] == 0){
						echo "<input type='checkbox' name='arhiva'/>";
					}else {
						echo "<input type='checkbox' name='arhiva' checked/>";
					}
				
				echo"
				</label>
				</div>
				
				<div id='buttons'>
					<input type ='hidden' name='id' value='" . $row['id'] . "'>
					<input name='delete' type='submit' value='Izbriši' />
					<input name='update' type='submit' value='Izmjeni'/>
				</div>
			</form>
			<br/><br/><hr/><br/><br/>";
		
		}
		
	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$query = "DELETE FROM vijest WHERE id=$id";
		$result = mysqli_query($dbc, $query);
	}
	
	if(isset($_POST['update'])){
		
		$slika = $_FILES['slika']['name'];
		$naslov = $_POST['naslov'];
		$sazetak = $_POST['sadrzaj'];
		$text = $_POST['text'];
		$kategorija = $_POST['kategorija'];
		$datum = date('M d Y');
		$arhiva = isset($_POST['arhiva']) ? 1 : 0;
		
		$id = $_POST['id'];
		
		$target_dir = 'images/' . $slika;
		move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);
		
		$querry="UPDATE vijest SET datum=?, naslov = ?, sazetak = ?, tekst = ?, slika = ?, kategorija = ?, arhiva = ?
				 WHERE id=$id";

		$stmt=mysqli_stmt_init($dbc);
		$success = false;
	
		if (mysqli_stmt_prepare($stmt, $querry)){

			mysqli_stmt_bind_param($stmt,'ssssssi', $datum, $naslov, $sazetak, $text, $slika, $kategorija, $arhiva);

			$success = mysqli_stmt_execute($stmt);
		} 
	}
	
	mysqli_close($dbc);
		
	echo";	
	</section>";
} else if(($prijavljenKorisnik && $admin == false) || (isset($_SESSION['username']) && $_SESSION['level'] != 1)) {
	echo "<div class='infotext'> 
			<p> Pozdrav ". $_SESSION['username'] . ". Uspješno ste prijavljeni, ali niste administrator. </p> 
			<form method='post' action='administracija.php'>
				<input type='submit' name='odjava' value='Odjava'/>
			</form>
		  </div>";
}

echo"
	<footer>
		<p> Petar Stambolija, 2021 </p>
	</footer>

</body>
</html>";



?>