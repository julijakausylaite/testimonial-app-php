<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Base HTML</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/scss/style.css">
	</head>
	<body>
		<?php 
		function dump($data){
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}

		//db prijungimas
		require_once "db_conn.php";
		$sql = 'SELECT * FROM testimonials';
		$result = $db->query($sql);
		// dump($result);
		?>

		<section class="homepage content">
			<h1>Homepage</h1>
			<div class="row justify-content-center">
				<?php
					if(!$result->num_rows):
						echo "rezultatu nerasta!";	
					else:
						for($i=0; $i<$result->num_rows; $i++):
							//gaunam viena irasa is $result objekto, issaugom i $row
							$row = mysqli_fetch_assoc($result);
							// dump($row);
							?>
							<!-- HTML kuris kartojasi -->
							<div class="col-12">
								<div class="single-testimonial">
									<div class="row">
										<div class="col-6">
											<h2><?php echo $row['name']; ?></h2>
										</div>
										<div class="col-6 text-right">
											<h3><?php echo $row['date']; ?></h3>
										</div>
									</div>
									<p><?php echo $row['text']; ?></p>
								</div>
							</div>
							<?php
						endfor;
					endif;
				?>
			</div>
			<a href="testimonial.php" class="btn btn-secondary">Rašyti atsiliepimą</a>
		</section>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="assets/scripts/custom.js"></script>
	</body>
</html>