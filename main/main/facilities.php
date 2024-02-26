<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('inc/links.php'); ?>
	<title> <?php echo $settings_r['site_title'] ?> -FACILITIES </title>

	<style>
		.pop:hover {
			border-top-color: var(--teal) !important;
			transform: scale(1.03);
			transition: all 0.3s;
		}
	</style>
</head>

<body class="bg-light">

	<?php require('inc/header.php') ?>

	<div class="my-5 px-4">
		<h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
		<div class="h-line bg-dark"></div>
		<P class="text-center mt-3">
			<!-- Lorem ipsum dolor sit amet consectetur adipisicing elit.
			Culpa aliquam dignissimos <br> in perferendis vitae ut ad,
			dolore quidem iusto ullam.
		</P> -->
	</div>

	<div class="container">
		<div class="row">
			<?php
				$result = selectAll('facilities');
				$path = FACILITIES_IMG_PATH;
				
				while($row = mysqli_fetch_assoc($result)){
					echo "
					<div class='col-lg-4 col-md-6 mb-5 px-4'>
					<div class='bg-white rounded shadow p-4 border-top border-4 border-dark pop'>
						<div class='d-flex align-items-center mb-2'>
							<img src='$path$row[icon]' width='40px'>
							<h5 class='m-0 ms-3'>$row[name]</h5>
						</div>
	
						<p>$row[description]</p>
					</div>
				</div>
					";
				}
			?>
		</div>
	</div>

	<?php require('inc/footer.php') ?>

</body>

</html>