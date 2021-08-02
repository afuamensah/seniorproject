<?php
	require("sidebar.php");
	include('dbconnect.php');

	$db = @new mysqli($db_server, $db_username, $db_password, $db_name);
	
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}

	$l_num = array();

	$fname = array();
	$lname = array();

	$time = array();

	$id = array();

	$checked = array();
	$warn = array();
	$suspend = array();


	$query = "SELECT * FROM profile, reports WHERE L_num=lnum";
	$result = $db->query($query);
	$notif = $result->num_rows;
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			for ($i=0; $i < $notif; $i++) {
				$l_num[$i] = $row['L_num'];
				$fname[$i] = $row['f_name'];
				$lname[$i] = $row['l_name'];
				$time[$i] = $row['r_time'];
				$status[$i] = $row['status'];
				$id[$i] = (int)$row['r_id'];
				$checked[$i] = (int)$row['checked'];
				$warn[$i] = (int)$row['warn'];
				$suspend[$i] = (int)$row['suspend'];
			}
		}
	}
?>
		<main>
		<div class="container">
			<div class="search border-bottom">
				<form action="rresults.php" method="post">
					<input class="form-control searchbar" type="text" name ="rsearch" placeholder="Search by L#..." aria-label="Search">
					<button class="search" type="submit"><img src="../img/search.png" class="s-icon"></button>
				</form>
            </div>
            <h1>Reports Center (2020-2021)</h1>
			<div class="container border dash">
			<?php
				if (!empty($fname)) {
					for ($i=0; $i < $notif; $i++) {
						echo '<div class="new-match">';
						if ($checked[$i] == 0) {
							echo '<span class="bold">'.$time[$i].' || Profile reported: '.$fname[$i].' '.$lname[$i].'</span>';
							echo '<div class="action">
								<form method="post">
									<input type="submit" name="details" class="btn btn-dark unread" value="View Details" />
								 </form></div>
							';
						} 
						else if ($checked[$i] == 1 && $warn[$i] == 1) {
							echo '<span>'.$time[$i].' || Profile reported: '.$fname[$i].' '.$lname[$i].'</span>';
							echo '<div class="action"><a class="yellow" href="report-details.php?lnum='.$l_num[$i].'">Warned</a></div>';
						}
						else if ($checked[$i] == 1 && $suspend[$i] == 1) {
							echo '<span>'.$time[$i].' || Profile reported: '.$fname[$i].' '.$lname[$i].'</span>';
							echo '<div class="action"><a class="red" href="report-details.php?lnum='.$l_num[$i].'">Suspended</a></div>';
						}

						else {
							echo '<span>'.$time[$i].' Profile reported: '.$fname[$i].' '.$lname[$i].'</span>';
							echo '<div class="action">
								<form method="post" action="report-details.php?lnum='.$l_num[$i].'">
									<input type="submit" name="details" class="btn btn-light read" value="View Details" />
								 </form></div>
							';
						}
						if(isset($_POST['details'])) { 
							$l_id = $id[$i];
							$sql = "UPDATE reports SET checked = 1 WHERE r_id = $l_id";
							$stmt = $db->query($sql);
						}
						echo '</div>';
					}
				}
			?>

			</div>
			<h6>Past Reports:</h6>
            <ul>
                <li><a href="#">2019-2020</a></li>
                <li><a href="#">2018-2019</a></li>
                <li><a href="#">2017-2018</a></li>
            </ul>
		</div>
	</main>
	<?php
	$db->close();
	require("footer.php");
?>