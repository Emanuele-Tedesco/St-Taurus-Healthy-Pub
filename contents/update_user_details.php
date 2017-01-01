<?php
	require 'functions.php';
	//include 'err_log.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['tel']) && isset($_POST['addr'])) {
			if (isset($_POST['vegan']) && isset($_POST['vegetarian'])) {
				$vegetarian = $vegan = 1;
			}
			else if (isset($_POST['vegan'])){
				$vegan = 1;
				$vegetarian = 0;
			}
			else if (isset($_POST['vegetarian'])) {
				$vegetarian = 1;
				$vegan = 0;
			}
			else {
				$vegetarian = $vegan = 0;
			}
			if ($conn = open_db_connection()) {
				$query = "UPDATE user SET tel = ".$_POST['tel'].", address = '".$_POST['addr']."', vegan = ".$vegan.", vegetarian = ".$vegetarian." where id = ".$_SESSION['session-id'];
				if ($conn->query($query))
					$_SESSION['user-details-updated'] = true;
				else
					$_SESSION['user-details-updated'] = false;
			}
			$conn->close();
			header("Refresh: 0; URL=http://st-tauruspub.servebeer.com/#user_details");
		}
	}
	else
		header("Refresh: 0; URL=not_found.php");
?>