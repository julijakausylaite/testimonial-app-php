<!DOCTYPE html>

<html lang="lt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Base HTML</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/scss/style.css">
	</head>
	<body>
	<?php 
		require_once "db_conn.php";
		function dump($data){
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
		
		// dump($_POST);
		if(isset($_POST['name'])):  // tikriname ar uzpildyti visi laukai
			
			// tikrinam ar ivede varda
			$errors = []; //masyvas klaidu pranesimams saugoti
			if(!empty($_POST['name'])):
				$name = mysqli_real_escape_string($db, html_entity_decode($_POST['name']));
				// mysqli_real_escape_string(db pavadinimas, kintamasis) - nekreipia demesio i spec simbolius, pvz kabutes. todel nebus galima iterpti sql kodo ir sugadinti db, palieka tik vienguba kabute, dvigubos ne
				// htmlentities(kintamasis) - palieka dvigubas kabutes
			else:
				array_push($errors,'Būtina nurodyti vardą');
			endif;

			// tikrinam ar ivede teksta
			if(!empty($_POST['text'])):
				$text = mysqli_real_escape_string($db, html_entity_decode($_POST['text']));
			else:
				array_push($errors,'Būtina įrašyti atsiliepimo tekstą');
			endif;

			// issaugom data ir laika kada ivestas atsiliepimas
			date_default_timezone_set('Europe/Vilnius'); 
			if(isset($_POST['submit'])):
				$date_clicked = date('Y-m-d H:i:s');
				$date = mysqli_real_escape_string($db, html_entity_decode($_POST['submit']));
				// echo "Time the button was clicked: " . $date_clicked . "<br>";
			endif;

			// dump($errors);

			// tikriname ar nera duomenu ivedimo klaidu
			if(empty($errors)): //patikrina ar klaidu masyvas yra tuscias
				//suformuojame sql uzklausa pagal suvestus duomenis kad ivesti juos i db
				$sql = 'INSERT INTO testimonials (name, text, date) VALUES ("'.$name.'", "'.$text.'","'.$date_clicked.'");';
				// dump($sql);
				// persiunciame uzklausa i DB, atsakyma issaugome
				$result = $db->query($sql);
				// dump($result);

				// jei uzklausa sekmingai ivykdyta tada istriname ivestus tekstus is formos
				if($result):
					unset($name, $text);
				endif;
			endif;
		endif;
	?>

		<section class="testimonial content">
			<h1>Atsiliepimas</h1>
			<form method="POST">
				<div class="row">
					<div class="col-12">
						<input type="text" placeholder="Vardas" name="name" value="<?php echo htmlentities(stripslashes($name ?? "")); ?>">
						<!-- stripslashes($kintamasis)  -leidzia isvesti kintamaji su kabutem(viengubom tik veikia) -->
					</div>
					<div class="col-12">
						<textarea name="text"><?php echo htmlentities(stripslashes($text ?? "")); ?></textarea>
					</div>
				</div>
				<button type="submit" name="submit" class="btn btn-secondary">Siųsti atsiliepimą</button>
				<div class="feedback">
					<?php 
					if(!empty($errors)):
						for($i=0; $i<=sizeof($errors)-1; $i++):
							echo $errors[$i]; ?><br><?php
						endfor;
					endif;
					?>
				</div>
			</form>
		</section>
		<?php
		
		?>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="assets/scripts/custom.js"></script>
	</body>
</html>