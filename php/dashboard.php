<?php
	require("sidebar.php");
	include('dbconnect.php');

	$db = @new mysqli($db_server, $db_username, $db_password, $db_name);
	
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}
	$fname1 = array();
	$lname1 = array();

	$time = array();

	$fname2 = array();
	$lname2 = array();

	$fname = array();
	$lname = array();

	$time2 = array();

	$query = "SELECT f_name, l_name, match_time, checked FROM profile, matches WHERE lnum1=L_num";
	$result = $db->query($query);
	$notif = $result->num_rows;
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			for ($i=0; $i < $result->num_rows; $i++) {
				$fname1[$i] = $row['f_name'];
				$lname1[$i] = $row['l_name'];
				$time[$i] = $row['match_time'];
				$m_checked[$i] = $row['checked'];
			}
		}
	}

	//$timestamp = new DateTime($time);
	//$timestamp = $timestamp->format('m/d/y h:ia');
	$query2 = "SELECT f_name, l_name FROM profile, matches WHERE lnum2=L_num";
	$result2 = $db->query($query2);
	if ($result2->num_rows > 0) {
		while ($row = $result2->fetch_assoc()) {
			for ($i=0; $i < $result2->num_rows; $i++) {
				$fname2[$i] = $row['f_name'];
				$lname2[$i] = $row['l_name'];
			}
		}
	}

	$query3 = "SELECT f_name, l_name, r_time, checked FROM profile, reports WHERE L_num=lnum";
	$result3 = $db->query($query3);
	$notif2 = $result3->num_rows;
	if ($result3->num_rows > 0) {
		while ($row = $result3->fetch_assoc()) {
			for ($i=0; $i < $result3->num_rows; $i++) {
				$fname[$i] = $row['f_name'];
				$lname[$i] = $row['l_name'];
				$time2[$i] = $row['r_time'];
				$r_checked[$i] = $row['checked'];
			}
		}
	}
	
	$db->close();
?>
		<main>
		<div class="container">
			<div class="search border-bottom">
				<form>
					<br>
				</form>
			</div>
			<h1>Dashboard</h1>
			<hr>
			<?php
				if (!empty($fname1)) {
					for ($i=0; $i < $result->num_rows; $i++) {
						if ($m_checked[$i] != 0) {
							$notif = $notif - 1;
						}
					}
				}
			?>
			<h4>New Matches <?php echo'('.$notif.')';?></h4>
			<div class="container border dash">
				<div class="container">
					<?php
						if (!empty($fname1)) {
							for ($i=0; $i < $result->num_rows; $i++) {
								if ($m_checked[$i] == 0) {
									echo '<b><div class="new-match border-bottom">';
									echo '<p>'.$time[$i].' || '.$fname1[$i].' '.$lname1[$i].' matched with '.$fname2[$i].' '.$lname2[$i].'!</p>';
									echo '</div></b>';
									echo '<hr>';
								}		 	
							}
							echo '<div>';
							echo '<a href="matches.php">Go to Matches Center...</a>';
							echo '</div>'; 
						}
					?>
				</div>
			</div>
			<br>
			<?php
				if (!empty($fname)) {
					for ($i=0; $i < $result3->num_rows; $i++) {
						if ($r_checked[$i] != 0) {
							$notif2 = $notif2 - 1;
						}
					}
				}
			?>
			<h4>New Reports <?php echo'('.$notif2.')';?></h4>
			<div class="container border dash">
				<div class="container">
				<?php
						if (!empty($fname)) {
							for ($i=0; $i < $result3->num_rows; $i++) {
								if ($r_checked[$i] == 0) {
									echo '<b><div class="new-match border-bottom">';
									echo '<p>'.$time2[$i].' || Profile reported: '.$fname[$i].' '.$lname[$i].'</p>';
									echo '</div></b>';
									echo '<hr>';
								}
							}
							echo '<div>';
							echo '<a href="reports.php">Go to Reports Center...</a>';
							echo '</div>'; 
						}
					?>
				</div>
			</div>
		</div>
	</main>
	<br>
<?php
	require("footer.php");
?>
