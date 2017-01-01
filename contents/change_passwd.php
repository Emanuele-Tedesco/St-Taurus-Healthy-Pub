<?php
	session_start();
	require 'functions.php';
	if (isset($_GET['action']) && isset($_GET['user'])) {
		if ($_POST['passwrd'] === $_POST['repasswrd'] && base64_decode($_GET['action']) == 'change-passwd') {
			if ($conn = open_db_connection()) {
				$user = base64_decode($_GET['user']);
				$query = "UPDATE user SET passwrd = '".SHA1($_POST['repasswrd'])."' WHERE email = '".$user."'";
				if ($conn->query($query)) {
					$_SESSION['passwd-changed'] = true;
				}
				else {
					$_SESSION['passwd-changed'] = false;
				}
				$conn->close();
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}
	}
?>