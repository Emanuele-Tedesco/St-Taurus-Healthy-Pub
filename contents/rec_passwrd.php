<?php
	session_start();
	require 'functions.php';
	//include 'err_log.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['email'])) {
			if ($conn = open_db_connection()) {
				$query = "SELECT COUNT(*) tot FROM user WHERE email = '".$_POST['email']."'";
				$resultset = get_resultset($conn, $query);
				$row = mysqli_fetch_assoc($resultset);
				if ($row['tot'] == 0) {
					$_SESSION['reg-posted'] = true;
					$_SESSION['rec-pass'] = false;
				}
				else {
					$query = "SELECT active, name FROM user WHERE email = '".$_POST['email']."'";
					$resultset = get_resultset($conn, $query);
					$row = mysqli_fetch_assoc($resultset);
					if ($row['active'] == 1) {
						$href = 'http://st-tauruspub.servebeer.com/reset_passwd.php?action='.rawurlencode(base64_encode('change-pass')).'&user='.rawurlencode(base64_encode($_POST['email']));
						$subject = 'Recupero password';
						$body = '<p>Hai ricevuto questa mail perchè è stato richiesto il ripristino della password per l\'account '.$_POST['email'].'</p>';
						$body .= '<p>Per impostare una nuova password <a href="'.$href.'">clicca qui</a>.</p>';
						$body .= '<hr/><p>Lo staff del St Taurus</p>';
						$recipients = array($_POST['email']);
						$from = 'St Taurus Healthy Pub';
						if (send_mail($subject, $body, $recipients, $from)) {
							$_SESSION['reg-posted'] = false;
							$_SESSION['rec-pass'] = 'active';
							$_SESSION['user-mail'] = $_POST['email'];
						}
					}
					else {
						$_SESSION['reg-posted'] = true;
						$_SESSION['user-mail'] = $_POST['email'];
						$_SESSION['user-name'] = $row['name'];
						$_SESSION['rec-pass'] = 'no-active';
					}
				}
				$conn->close();
			}
		}
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
?>