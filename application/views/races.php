<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<meta charset="utf-8">
	<title></title>

</head>
<body>
	

	<div class="container">
		<h1>Active Race(s)</h1>
		<?php foreach ($activeRaces as $race): ?>


			<strong>Time: </strong> <?php echo $race->time ?> seconds<br>
			<?php foreach ($race->horses as $horse): ?>
				<span>Horse No: <?php echo $horse->no ?>
				Distance: <?php echo number_format($horse->distance,2) ?> meters
			</span> <br>
			<div class="progress">
				<div class="progress-bar" role="progressbar"   aria-valuenow="<?php echo (number_format($horse->distance,0,'',''))?>" aria-valuemin="0" style="width: <?php echo (number_format(($horse->distance/1500*100),0, '','')) ."%"; ?>" aria-valuemax="1500">
					<?php echo (number_format(($horse->distance/1500*100),0, '','')) ."%"; ?>

				</div>
			</div>
		<?php endforeach ?>

		
		<hr>
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	<?php endforeach ?>
</div>
<div class="container">
	<div class="row">
		<a class="btn btn-default" href="create-race">Create Race</a>
		<a class="btn btn-default" href="advance">Progress</a>
	</div>
	</div>

	<div class="container"><h1>Last Five Races</h1>
		<?php foreach ($lastFiveRace as $race): ?>
			<strong>Duration: </strong> <?php echo $race->time ?> seconds<br>
			<strong>1st Place: </strong> 
			<ul>
				<li><strong>No: </strong><?php echo $race->horses[0]->no ?></li>
				<li><strong>Speed: </strong><?php echo $race->horses[0]->speed  ?></li>
				<li><strong>Strentgh: </strong><?php echo $race->horses[0]->strength; ?></li>
				<li><strong>Enducance: </strong><?php echo $race->horses[0]->endurance ?></li>
			</ul>
			<strong>2nd Place: </strong> 
			<ul>
				<li><strong>No: </strong><?php echo $race->horses[1]->no ?></li>
				<li><strong>Speed: </strong><?php echo $race->horses[1]->speed  ?></li>
				<li><strong>Strentgh: </strong><?php echo $race->horses[1]->strength; ?></li>
				<li><strong>Enducance: </strong><?php echo $race->horses[1]->endurance ?></li>
			</ul>
			<strong>3rd Place: </strong> 
			<ul>
				<li><strong>No: </strong><?php echo $race->horses[2]->no ?></li>
				<li><strong>Speed: </strong><?php echo $race->horses[2]->speed  ?></li>
				<li><strong>Strentgh: </strong><?php echo $race->horses[2]->strength; ?></li>
				<li><strong>Enducance: </strong><?php echo $race->horses[2]->endurance ?></li>
			</ul>
			
			<hr>
		<?php endforeach ?>
	</div>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
</body>
</html>