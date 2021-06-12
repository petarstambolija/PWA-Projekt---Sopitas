<?php

?>

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
	
	<section id='forma'>
		
		<form enctype='multipart/form-data' method='post' action='skripta.php'>
		
			Naslov:
			<br>
			<input name='naslov' id='naslov' type='text' />
			<span id="porukaNaslov" class="errorPoruka"></span>
			<br/>
			Kratki sadržaj vjesti (do 100 znakova):
			<br/>
			<textarea name='sadrzaj' id='sadrzaj' ></textarea>
			<span id="porukaSadrzaj" class="errorPoruka"></span>
			<br>
			Sadržaj vjesti:
			<br/>
			<textarea name='text' id='text' ></textarea>
			<span id="porukaText" class="errorPoruka"></span>
			<br>
			Photo:
			<br/>
			<input name='slika' id='slika' type='file' />
			<span id="porukaSlika" class="errorPoruka"></span>
			<br/>
			Kategorija
			<br>
			<select name='kategorija'>
				<option value='Sport'> Sport </option>
				<option value='Muzika'> Muzika </option>
			</select>
			<br>
			<div id='arhiva'>
				<label> Spremiti u arhivu?:
				<input type='checkbox' name='arhiva'/>
				</label>
			</div>
			
			<div id='buttons'>
				<input name='reset' type='reset' value='Resetiraj' />
				<input name='submit' type='submit' id='submit' value='Pošalji'/>
			</div>
		</form>
		
		
	<script type="text/javascript">
		
			document.getElementById('submit').onclick = function(event) {
				
				var slanjeForme = true;
				
				//Naslov vijesti (5-30 znakova)
				
				var poljeNaslov = document.getElementById('naslov');
				var naslov = document.getElementById('naslov').value;
				var porukaNaslov = document.getElementById("porukaNaslov");
				
				if(naslov.length < 5 ||naslov.length > 100) {
					slanjeForme = false;
					poljeNaslov.style.border = "1px dashed red";
					porukaNaslov.innerHTML="Naslov mora imati između 5 i 100 znakova!<br>";
				}
				else {
					poljeNaslov.style.border = "1px solid green";
					porukaNaslov.innerHTML = "";
				}
				
				//Kratki sadržaj (10-100 znakova)
				
				var poljeSadrzaj = document.getElementById('sadrzaj');
				var sadrzaj = document.getElementById('sadrzaj').value;
				var porukaSadrzaj = document.getElementById("porukaSadrzaj");
				
				if(sadrzaj.length < 10 || sadrzaj.length > 100) {
					slanjeForme = false;
					poljeSadrzaj.style.border = "1px dashed red";
					porukaSadrzaj.innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
				}
				else {
					poljeSadrzaj.style.border = "1px solid green";
					porukaSadrzaj.innerHTML = "";
				}
				
				//Sadržaj (mora biti unesen)
				
				var poljeText = document.getElementById('text');
				var text = document.getElementById('text').value;
				var porukaText = document.getElementById("porukaText");
				
				if(text.length == 0) {
					slanjeForme = false;
					poljeText.style.border = "1px dashed red";
					porukaText.innerHTML="Sadržaj mora biti unesen!<br>";
				}
				else {
					poljeText.style.border = "1px solid green";
					porukaText.innerHTML = "";
				}
				
				//Slika (mora biti unesena)
				
				var poljeSlika = document.getElementById('slika');
				var slika = document.getElementById('slika').value;
				var porukaSlika = document.getElementById("porukaSlika");
				
				if(slika.length == 0) {
					slanjeForme = false;
					poljeSlika.style.border = "1px dashed red";
					porukaSlika.innerHTML="Slika mora biti unesena!<br>";
				}
				else {
					poljeSlika.style.border = "1px solid green";
					porukaSlika.innerHTML = "";
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
