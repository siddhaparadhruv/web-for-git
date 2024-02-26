<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
	<?php require('inc/links.php')?>
	<title> <?php echo $settings_r['site_title'] ?> -ABOUT </title>
	<style>
		.box{
			border-top-color: var(--teal) !important;
		}
	</style>
</head>
<body class="bg-light">

	<?php require('inc/header.php') ?>

	<div class="my-5 px-4">
	<h2 class="fw-bold h-font text-center">ABOUT US</h2>
	<div class="h-line bg-dark"></div>
	<P class="text-center mt-3">
		<!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. 
		Culpa aliquam dignissimos <br> in perferendis vitae ut ad, 
		dolore quidem iusto ullam. -->
	</P>
	</div>

	<div class="container mt-5">
		<div class="row justify-content-between align-items-center">
			<div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
				<h3 class="mb-3"></h3>
				<p>
				HOTEL HOLIDAYS Online hotel reservations are a popular method for booking hotel rooms. Travellers can book rooms on a computer by using online security to protect their privacy and financial information and by using several online travel agents to compare prices and facilities at different hotels.

Prior to the Internet, travellers could write, telephone the hotel directly, or use a travel agent to make a reservation. Nowadays, online travel agents have pictures of hotels and rooms, information on prices and deals, and even information on local resorts. Many also allow reviews of the traveler to be recorded with the online travel agent.

Online hotel reservations are also helpful for making last minute travel arrangements. Hotels may drop the price of a room if some rooms are still available. There are several websites that specialize in searches for deals on rooms.
				</p>
			</div>
			<div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
				<img src="images/about/about.jpg" class="w-100">
			</div>
		</div>
	</div>

	<div class="container mt-5">
		<div class="row">
			<div class="col-lg-3 col-md-6 mb-4 px-4">
				<div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
					<img src="images/about/hotel.svg" width="70px">
					<h4 class="mt-3">100+ ROOMS</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 mb-4 px-4">
				<div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
					<img src="images/about/customers.svg" width="70px">
					<h4 class="mt-3">200+CUSTOMERS</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 mb-4 px-4">
				<div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
					<img src="images/about/rating.svg" width="70px">
					<h4 class="mt-3">150+ REVIEWS</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 mb-4 px-4">
				<div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
					<img src="images/about/staff.svg" width="70px">
					<h4 class="mt-3">200+ STAFFS</h4>
				</div>
			</div>
		</div>
	</div>

	<h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>

		<div class="container px-4">
		  <div class="swiper mySwiper">
			<div class="swiper-wrapper mb-5">

			<?php
				$about_r = selectAll('team_details');
				$path=ABOUT_IMG_PATH;
				while($row = mysqli_fetch_assoc($about_r)){
					echo "<div class='swiper-slide bg-white text-center overflow-hidden rounded'>
					<img src='$path$row[picture]' class='w-100'>
					<h5 class='mt-2'>$row[name]</h5>
				</div>";
				}
			?>
			</div>
			<div class="swiper-pagination"></div>
 		 </div>
		</div>

	<?php require('inc/footer.php')?>

	<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

 
  <script>
    	var swiper = new Swiper(".mySwiper", {
		
		spaceBetween: 40,	
      	pagination: {
        el: ".swiper-pagination",
      },
	  breakpoints: {
		320:{
			slidesPerView: 1,
		},
		640:{
			slidesPerView: 1,
		},
		768:{
			slidesPerView: 2,
		},
		1024:{
			slidesPerView: 3,
		},
	  }
    });
  </script>

</body>
</html>