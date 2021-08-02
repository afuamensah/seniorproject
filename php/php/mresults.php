<?php
	require("sidebar.php");
	include('dbconnect.php');

	$db = @new mysqli($db_server, $db_username, $db_password, $db_name);
	
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}

    $inquiry=$_POST['msearch'];
    
	$fname1 = array();
	$lname1 = array();

	$time = array();

	$fname2 = array();
	$lname2 = array();

	$id = array();
	$checked = array();
	$confirm = array();

	$query = "SELECT * FROM profile, matches WHERE (lnum1= '$inquiry' or lnum2='$inquiry') and lnum1=L_num";
	$result = $db->query($query);
	$notif = $result->num_rows;
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			for ($i=0; $i < $notif; $i++) {
				$fname1[$i] = $row['f_name'];
				$lname1[$i] = $row['l_name'];
				$time[$i] = $row['match_time'];
				$id[$i] = (int)$row['m_id'];
				$checked[$i] = (int)$row['checked'];
				$confirm[$i] = (int)$row['confirm_match'];
			}
		}
	}

	//$timestamp = new DateTime($time);
	//$timestamp = $timestamp->format('m/d/y h:ia');
	$query2 = "SELECT f_name, l_name FROM profile, matches WHERE lnum2=L_num";
	$result2 = $db->query($query2);
	if ($result2->num_rows > 0) {
		while ($row = $result2->fetch_assoc()) {
			for ($i=0; $i < $notif; $i++) {
				$fname2[$i] = $row['f_name'];
				$lname2[$i] = $row['l_name'];
			}
		}
	}
	
?>
		<main>
		<div class="container">
			<div class="search border-bottom">
				<form action="mresults.php" method="post">
					<input class="form-control searchbar" type="text" name ="msearch" placeholder="Search by L#..." aria-label="Search">
					<button class="search" type="submit"><img src="../img/search.png" class="s-icon"></button>
				</form>
            </div>
            <h1>Matches Results</h1>
					<?php
						if (!empty($fname1)) {
							echo '<div class="container border dash">';
							for ($i=0; $i < $notif; $i++) {
								echo '<div class="new-match">';
								if ($checked[$i] == 0) {
									echo '<span class="bold">'.$time[$i].' || <a href="profile.php?lnum='.$l_num1[$i].'">'.$fname1[$i].' '.$lname1[$i].'</a> matched with <a href="profile.php?lnum='.$l_num1[$i].'">'.$fname2[$i].' '.$lname2[$i].'</a>!</span>';
									echo '<div class="choose action">
									<form method="post">
										<input type="submit"  class="button btn btn-outline-success choose" id="confirm" name="confirm" value="Confirm" />
										<input type="submit" class="button btn btn-outline-danger" id="deny" name="deny" value="Deny" />
									</form></div>';
								} else {
									echo '<span>'.$time[$i].' || <a href="profile.php?lnum='.$l_num1[$i].'">'.$fname1[$i].' '.$lname1[$i].'</a> matched with <a href="profile.php?lnum='.$l_num1[$i].'">'.$fname2[$i].' '.$lname2[$i].'</a>!</span>';
								}
								if ($checked[$i] == 1 && $confirm[$i] == 0) {
									echo '<div class="no">Denied</div>';
								}
								if ($checked[$i] == 1 && $confirm[$i] == 1) {
									echo '<div class="yes">Confirmed</div>';
								}

								if(isset($_POST['deny'])) { 
									$sql = "UPDATE matches SET checked = 1 WHERE m_id = $id[$i]";
									$stmt = $db->query($sql);

									header("Refresh:0");
								}
								if(isset($_POST['confirm'])) { 
									$sql = "UPDATE matches SET checked = 1, confirm_match = 1 WHERE m_id = $id[$i]";
									$stmt = $db->query($sql);

									header("Refresh:0");
								}
								}
								echo '</div>';
								echo '</div>';
							}
							else if (!$inquiry) {
								echo '<p>You have not entered a search.<br/>
								Please go back and try again.</p>';
							}
							else if (strlen($inquiry) != 8) {
								echo '<p>Your search is not a valid L number. Try again.</p>';
							}
							else {
								echo '<p>There are no results. Please fix or make a new search.</p>';
							}

					?>
		</div>
	</main>
	<br>
	<?php
	$db ->close();
	require("footer.php");
?>