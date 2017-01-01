<?php
	require 'functions.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['username']) && isset($_POST['password'])) {
			if ($conn = open_db_connection()) {
				$query = "SELECT id, active, type, name, email FROM user WHERE (email = '".$_POST['username']."' AND passwrd = '".sha1($_POST['password'])."')";
				if ($resultset = get_resultset($conn, $query)) {
					if (!$resultset->num_rows)
						 $_SESSION['login-action'] = 'no-match';
					else {
						$row = mysqli_fetch_assoc($resultset);
						if ($row['active']) {
							$userId = $row['id'];
							$userMD5 = md5($row['id']);
							if ($userId * $row['type'] == $userId)
								$userId = 'admin';
							setcookie('SESSION-ID', $userMD5, time() + 900, '/');
							$_SESSION['session-id'] = $userId;
							$_SESSION['name'] = substr($row['name'], 0, strpos($row['name'], ' '));
							//echo $_SESSION['SESSION-CREATED'] = time();
							$query = "UPDATE user SET data_last_login = NOW() WHERE id = ".$userId;
							$conn->query($query);
						}
						else {
							$_SESSION['user-name'] = $row['name'];
							$_SESSION['user-mail'] = $row['email'];
							$_SESSION['login-action'] = 'no-active';
						}
					}
				}
				$conn->close();
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}
	}
?>