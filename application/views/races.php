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
		<div class="row">
			<a class="btn btn-primary" href="create-race">Create Race</a>
			<a class="btn btn-success" href="advance">Progress</a>
		</div>
	</div>

	<div class="container">
		<?php if(isset($fastest)): ?>
			<strong>Best Time</strong>
			<?php echo number_format($fastest->raceCompleteTiming, 1) ?> seconds<br>
			<strong>Best Horse</strong>
			<ul>
				
				<li><strong>Speed: </strong><?php echo $fastest->speed  ?></li>
				<li><strong>Strentgh: </strong><?php echo $fastest->strength; ?></li>
				<li><strong>Endurance: </strong><?php echo $fastest->endurance ?></li>
			</ul>

		<?php endif; ?>
		<?php if(!empty($activeRaces)): ?>
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
	<?php endif; ?>
</div>

<?php if(!empty($lastFiveRace)): ?>
	<div class="container"><h1>Last <?=sizeof($lastFiveRace) ?> Races</h1>
		<?php foreach ($lastFiveRace as $race): ?>
			<strong>Total Race Time: </strong> <?php echo $race->time ?> seconds<br>
			<?php for ($i = 0; $i < 3; $i++) :?>
				<div style="float:left">
					<strong><?=$i+1 ?>. Place: </strong> 
					<ul >
						<li><strong>No: </strong><?php echo $race->horses[$i]->no ?></li>
						<li><strong>Speed: </strong><?php echo $race->horses[$i]->speed  ?></li>
						<li><strong>Strentgh: </strong><?php echo $race->horses[$i]->strength; ?></li>
						<li><strong>Endurance: </strong><?php echo $race->horses[$i]->endurance ?></li>
						<li><strong>Duration:</strong><?php echo number_format($race->horses[$i]->raceCompleteTiming, 1) ?> seconds</li>

					</ul>				
				</div>

			<?php endfor ?>
			<div class="clearfix"></div>
			<hr>



		<?php endforeach ?>
	</div>
<?php endif ?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
</body>
</html>