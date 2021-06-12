<?php

include 'connect.php';

?>

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
		
	</header>
	
	<section id='forma'>
	
		<form method='post' action='registracija.php'>
				
			Ime:
			<br/>
			<input name='ime' id='ime' type='text'/>
			<span id='porukaIme' class='errorPoruka' ></span>
			<br/>
			Prezime:
			<br/>
			<input name='prezime' id='prezime' type='text'/>
			<span id='porukaPrezime' class='errorPoruka' ></span>
			<br/>
			Korisničko ime:
			<br/>
			<input name='username' id='username' type='text'/>
			<span id='porukaUsername' class='errorPoruka' ></span>
			<br/>
			Lozinka:
			<br/>
			<input name='password' id='password' type='password'/>
			<span id='porukaPassword' class='errorPoruka' ></span>
			<br/>
			Ponovite lozinku:
			<br/>
			<input name='password2' id='password2' type='password'/>
			<span id='porukaPassword2' class='errorPoruka' ></span>
			<br/>
			<input name='submit' id='submit' type='submit' value='Registriraj se!'/>
		
		</form>
	
		<script type="text/javascript">
		
			document.getElementById('submit').onclick = function(event) {
				
				var slanjeForme = true;
				
				//Ime
				
				var poljeIme = document.getElementById('ime');
				var ime = document.getElementById('ime').value;
				var porukaIme = document.getElementById("porukaIme");
				
				if(ime.length <= 0) {
					slanjeForme = false;
					poljeIme.style.border = "1px dashed red";
					porukaIme.innerHTML="Unesite ime!<br>";
				}
				else {
					poljeIme.style.border = "1px solid green";
					porukaIme.innerHTML = "";
				}
				
				//Prezime
				
				var poljePrezime = document.getElementById('prezime');
				var prezime = document.getElementById('prezime').value;
				var porukaPrezime = document.getElementById("porukaPrezime");
				
				if(prezime.length == 0) {
					slanjeForme = false;
					poljePrezime.style.border = "1px dashed red";
					porukaPrezime.innerHTML="Unesite prezime!<br>";
				}
				else {
					poljePrezime.style.border = "1px solid green";
					porukaPrezime.innerHTML = "";
				}
				
				//Username
				
				var poljeUsername = document.getElementById('username');
				var username = document.getElementById('username').value;
				var porukaUsername = document.getElementById("porukaUsername");
				
				if(username.length == 0) {
					slanjeForme = false;
					poljeUsername.style.border = "1px dashed red";
					porukaUsername.innerHTML="Unesite username!<br>";
				}
				else {
					poljeUsername.style.border = "1px solid green";
					porukaUsername.innerHTML = "";
				}
				
				//Lozinka
				
				var poljePassword = document.getElementById('password');
				var poljePassword2 = document.getElementById('password2');
				var password = document.getElementById('password').value;
				var password2 = document.getElementById('password2').value;
				var porukaPassword = document.getElementById("porukaPassword");
				var porukaPassword2 = document.getElementById("porukaPassword2");
				
				if(password.length == 0) {
					slanjeForme = false;
					poljePassword.style.border = "1px dashed red";
					porukaPassword.innerHTML="Unesite lozinku!<br>";
				} 
				else if(password != password2) {
					slanjeForme = false;
					
					poljePassword.style.border = "1px dashed red";
					porukaPassword.innerHTML="Lozinke nisu iste!<br>";
					
					poljePassword2.style.border = "1px dashed red";
					porukaPassword2.innerHTML="Lozinke nisu iste!<br>";
				}
				else {
					poljePassword.style.border = "1px solid green";
					porukaPassword.innerHTML = "";
					
					poljePassword2.style.border = "1px solid green";
					porukaPassword2.innerHTML = "";
				}
				
				if(slanjeForme != true){
					event.preventDefault();
				}
			}
		
		</script>
	
	</section>
	
	<footer>
		<p> Petar Stambolija, 2021 </p>
	</footer>

</body>
</html>

<?php

if(isset($_POST['submit'])){

	$ime = $_POST['ime'];
	$prezime = $_POST['prezime'];
	$username = $_POST['username'];
	$lozinka = $_POST['password'];
	$lozinka2 = $_POST['password2'];
	$razina = 0;

	if($lozinka == $lozinka2){
		
		$hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
	
		$query="INSERT INTO korisnik (ime, prezime, username, password, level) values (?, ?, ?, ?, ?)";

		$stmt=mysqli_stmt_init($dbc);
		$success = false;
	
		if (mysqli_stmt_prepare($stmt, $query)){

			mysqli_stmt_bind_param($stmt,'ssssi', $ime, $prezime, $username, $hashed_password, $razina);

			$success = mysqli_stmt_execute($stmt);
		}
		
		if($success) {
		
			$_SESSION['username'] = $username;
			$_SESSION['level'] = $razina;
			
		}
		
		mysqli_close($dbc);
		
	}
}

?>
