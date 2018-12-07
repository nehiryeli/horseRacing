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
	
	<div class="container"><h1>Last Five Races</h1>
		<?php foreach ($lastFiveRace as $race): ?>
			<?php print_r($race) ?>
			<hr>
		<?php endforeach ?>
	</div>
	<div class="container">
		<h1>Active Race(s)</h1>
		<?php foreach ($activeRaces as $race): ?>
			<div class="row">
				<?php foreach ($race->horses as $horse): ?>
					<p>Horse NO: <?php echo $horse->no ?>
					Distance: <?php echo $horse->distance ?>
					</p>

				<?php endforeach ?>

			</div>
			<hr>

		<?php endforeach ?>
	</div>
	<div class="container">
		<div class="row">
			<a class="btn btn-default" href="create-race">Create Race</a>
			<a class="btn btn-default" href="advance">Progress</a>
		</div>
	</div

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
</body>
</html>