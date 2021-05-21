<?php
	require("sidebar.php");
	include('dbconnect.php');

	$db = @new mysqli($db_server, $db_username, $db_password, $db_name);
	
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}
    $l_num = $_GET['lnum'];
	$query = "SELECT * FROM profile WHERE L_num = $l_num";
	$result = $db->query($query);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$pic = $row['prof_pic'];
			$f_name = $row['f_name'];
			$l_name = $row['l_name'];
			$bday = $row['bday'];
			$class = $row['class'];
			$warn = $row['num_warn'];
			$suspend = $row['num_suspend'];
		}
	}

	$bday_calc = new DateTime($bday);
	$today = new DateTime(date('y-m-d'));
	$age_calc = $today->diff($bday_calc);
	$age = $age_calc->y;
?>
		<main>
		<div class="container">
		<br>
			<h1>Matches Center: Profile Details</h1>
			<div class="back">
				<a href="matches.php">&lt;&lt; Back to Matches Center</a>
			</div>
			<div class="container">
				<div class="row">
					<div class="col">
							<img src="<?php echo $pic;?>" width="350" height="auto">
					</div>
					<div class="col info">
						<h2>
							<?php
								echo $f_name.' '.$l_name;
							?>
						</h2>
						<ul>
							<li>
								<?php
									echo '<b>Age: </b>'.$age;
								?>
							</li>
							<li>
								<?php
									echo '<b>Classification: </b>'.$class;
								?>
							</li>
							<br>
							<li>
								<?php
									echo '<b>Number of warnings: </b>'.$warn;
								?>
							</li>
							<li>
								<?php
									echo '<b>Number of suspensions: </b>'.$suspend;
								?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php
	$db->close();
	require("footer.php");
?>