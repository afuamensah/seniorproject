<?php
	
	require("sidebar.php");
	include('dbconnect.php');
	include("email-config.php");

	$db = @new mysqli($db_server, $db_username, $db_password, $db_name);
	
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}
    $l_num = $_GET['lnum'];
	$query = "SELECT * FROM profile, reports WHERE L_num = $l_num";
	$result = $db->query($query);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
            $id = $row['r_id'];
			$pic = $row['prof_pic'];
			$f_name = $row['f_name'];
			$l_name = $row['l_name'];
			$email = $row['email'];
			$bday = $row['bday'];
			$class = $row['class'];
			$status = $row['status'];
			$num_warn = (int)$row['num_warn'];
			$num_suspend = (int)$row['num_suspend'];
			$reason = $row['category'];
			$comment = $row['comment'];
			$warn = (int)$row['warn'];
			$suspend = (int)$row['suspend'];
		}
	}

	$bday_calc = new DateTime($bday);
	$today = new DateTime(date('y-m-d'));
	$age_calc = $today->diff($bday_calc);
	$age = $age_calc->y;

	if(isset($_POST['warning'])) { 
		$warn = 1;

		$sql = "UPDATE reports SET warn = ?, status = 'Warned' WHERE r_id = $id";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('i', $warn);
		$stmt->execute();

		$num_warn = $num_warn + 1;

		$sql2 = "UPDATE profile SET num_warn = ? WHERE L_num = $l_num";
		$stmt2 = $db->prepare($sql2);
		$stmt2->bind_param('i', $num_warn);
		$stmt2->execute();

		header("Refresh: 0");

		if ($warn == 1) {

			$recipient = $email;
			$subject = 'Warning Issued';
			$plainmsg =  'You have been warned for the following reason: \n'.$reason.'\n Your actions regarding this reason have gone against Herdr\'s rules. \n Continuation of this violation or any other violaton of Herdr\'s rules may result in a temporary or permanent suspension. If you have any questions regarding your warning, please e-mail us through the e-mail address herdrcontact@gmail.com. \n\n  -Herdr Admin';
			$msg = '<html>
					<head>
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
					</head>
					<body>
					<div style="background-color: #a48cac3b; padding: 30px;">
						<div style="background: #fff url(http://ec2-3-134-86-121.us-east-2.compute.amazonaws.com/webapp/logo.png) no-repeat 50% 10%/150px; padding: 70px; box-shadow: 3px 3px 3px #ccc;">
						<h1 style="font-size: 42px; text-align: center; padding-top: 90px; padding-bottom: 20px; font-weight: bold; color: #272727;">Warning Issued</h1>
						<hr>
						<p style="padding-top: 40px; font-size: 16px; ">You have been warned for the following reason:
							<br>
							<h1 style="font-size: 30px; padding-left: 30px;">'.$reason.'</h1>
							<br>
							Your actions regarding this reason have gone against Herdr\'s rules.
							<br><br>
							Continuation of this violation or any other violaton of Herdr\'s rules may result in a temporary or permanent suspension. If you have any questions regarding your warning, please e-mail us through the e-mail address herdrcontact@gmail.com.
							<br>
							<p style="font-weight: bold; padding-top: 50px; color: #7a7a7a; font-size: 14px;">Herdr Admin</p>
						</p>
						</div>
					</div>
					</body>
				</html>';
	
			sendMail($recipient, $subject, $plainmsg, $msg);
		}
	

	}

	if(isset($_POST['suspension'])) { 
		$suspend  = 1;

		$sql = "UPDATE reports SET suspend = ?, status = 'Suspended' WHERE r_id = $id";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('i', $suspend);
		$stmt->execute();

		$num_suspend = $num_suspend + 1;

		$sql2 = "UPDATE profile SET num_suspend = ? WHERE L_num = $l_num";
		$stmt2 = $db->prepare($sql2);
		$stmt2->bind_param('i', $num_suspend);
		$stmt2->execute();

		header("Refresh: 0");

		if ($suspend == 1) {

			$recipient = $email;
			$subject = 'Suspension';
			$plainmsg =  'You have been suspended for the following reason: \n'.$reason.'\n Your actions regarding this reason have gone against Herdr\'s rules. \n Continuation of this violation or any other violaton of Herdr\'s rules may result in a temporary or permanent suspension. If you have any questions regarding your warning, please e-mail us through the e-mail address herdrcontact@gmail.com. \n\n  -Herdr Admin';
			$msg = '<html>
					<head>
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
					</head>
					<body>
					<div style="text-align: center;">
					<img src="http://herdr-site.eba-qdskzceb.us-east-2.elasticbeanstalk.com/logo.png" width="200">
					<h1>Warning Issued</h1><p>';
			$msg .= 'You have been warned for the following reason: <br><br><h1>'.$reason.'</h1><br><br> Your actions regarding this reason have gone against Herdr\'s rules. <br>Continuation of this violation or any other violaton of Herdr\'s rules may result in a temporary or permanent suspension. If you have any questions regarding your warning, please e-mail us through the e-mail address herdrcontact@gmail.com. <br><br>  <b>-Herdr Admin</b>';
			$msg .= '</p></div>
					</body>
					</html>';
	
			sendMail($recipient, $subject, $plainmsg, $msg);
		}

	}
	$db->close();
?>
		<main>
		<div class="container">
			<br>
			<h1>Reports Center: Profile Details</h1>
			<div class="back">
				<a href="reports.php">&lt;&lt; Back to Reports Center</a>
			</div>
			<div class="container">
				<div class="row">
					<div class="col">
						<img src="<?php echo $pic;?>" width="350" height="auto">
					</div>
					<div class="col info">
						<h2><?php
								echo $f_name.' '.$l_name;
							?></h2>
						<ul>
							<li><?php
									echo '<b>Status: </b>'.$status;
								?></li>
							<li><?php
									echo '<b>Age: </b>'.$age;
								?></li>
							<li><?php
									echo '<b>Classification: </b>'.$class;
								?></li>
							<br>
							<li><?php
									echo '<b>Number of warnings: </b>'.$num_warn;
								?></li>
							<li><?php
									echo '<b>Number of suspensions: </b>'.$num_suspend;
								?></li>
							<br>
							<li><?php
									echo '<b>Reason for report: </b>'.$reason;
								?></li>
							<li><?php
									echo '<b>Comments from report: </b>'.$comment;
								?></li>
						</ul>
					</div>
				</div>
			</div>
			<?php
				if ($warn == 0 && $suspend == 0) {
					echo '<form method="post">
               			<input type="submit" class=" button btn btn-warning r-action warn" name="warning" value="Warn Account" />
			   			<input type="submit" class=" button btn btn-danger r-action " name="suspension" value="Suspend Account" />
            		</form>';
				}
				
			?>
            
		</div>
	</main>
<?php
	require("footer.php");
?>