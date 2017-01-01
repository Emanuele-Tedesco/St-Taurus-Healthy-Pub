<?php
    session_start();
	//include 'err_log.php';
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'check_session')
			checkSession();
		else {
			$action = base64_decode($_GET['action']);
			switch ($action) {
				case 'resend_act_mail':
					sendActivationMail($_SESSION['user-name'], $_SESSION['user-mail']);
					$_SESSION['rec-pass'] = 'active';
					$_SESSION['reg-posted'] = true;
					unset ($_SESSION['user-name']);
					header("Location: {$_SERVER['HTTP_REFERER']}");
					break;
				case 'session-close':
					session_unset();
					session_destroy();
					header("Location: {$_SERVER['HTTP_REFERER']}");
				default:
					break;
			}
		}
	}
	
	function open_db_connection() {
		$conn = new mysqli('localhost','app_user','pinoinsegno','taurus');
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}
		else {
			return $conn;
		}
	}
	
	function get_resultset($connection, $query) {
		$resultset = $connection->query($query) or die( 'Err: ' . $connection->error );
		return $resultset;
	}
	
	function send_mail($subject, $body, $recipients, $from) //send_mail('test', '<p>Test di invio <b>mail</b></p>', $recipients, 'service-test');
	{
		require 'PHPMailer-master/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'st.taurus.service@gmail.com';                 // SMTP username
		$mail->Password = 'pinoinsegno';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('no-reply@st.taurus.service', $from);
		$mail->addReplyTo('not-reply@st.taurus.it', 'no-reply');
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		$mail->SMTPKeepAlive = true;
		//$mail->addAddress('manutede@gmail.com');     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		
		foreach($recipients as $address) {
			$mail->addAddress($address);
			if(!$mail->send()) {
				$mail->SMTPDebug = 2;
				echo 'Mailer Error: ' . $mail->ErrorInfo;
				return false;
			}
			else {
				return true;
			}
			$mail->clearAddresses();
    		//$mail->clearAttachments();
		}
	}
	
	function sendActivationMail($name, $email) {
		$href = 'http://st-tauruspub.servebeer.com/t-index.php?action='.rawurlencode(base64_encode('activate')).'&user='.rawurlencode(base64_encode($email));
		$subject = 'Conferma registrazione su st-tauruspub.servebeer.com';
		$body =  '<p><h3>Ciao <b>'.substr($name,0,(strpos($name, ' '))).'</b>!</h3></p>';
		$body .= '<p>Ti diamo il benvenuto sul portale del St Taurus Healthy Pub.</p>';
		$body .= '<p>Per procedere con l\'attivazione del tuo account ti basta <a href="'.$href.'">cliccare qui</a>!</p>';
		$body .= '<p>Ti aspettiamo!</p>';
		$body .= '<hr/><p>Lo staff del St Taurus</p>';
		$from = 'St Taurus Healty Pub';
		$recipients = array($email);
		if (send_mail($subject, $body, $recipients, $from)) {
			$result = 'ok';
		}
		else {
			$result = 'Mail Err';				
			$query = "SET @p0='.$email.'; CALL `del_user`(@p0);";
			$query1 = 'CALL update_ai()';
			$conn->query($query);
			$conn->query($query1);
		}
		return $result;
	}
	
	
	function activeUser($user) {
		$user = base64_decode($user);
		$conn = open_db_connection();
		$query = "SELECT active, name FROM user WHERE email = '".$user."'";
		$result = get_resultset($conn, $query);
		$row = mysqli_fetch_assoc($result);
		if ($row['active'] == 0) {
			$name = $row['name'];
			$query = "UPDATE user set active = 1 WHERE email = '".$user."'";
			if($conn->query($query)) {
				$_SESSION['user_name'] = substr($name, 0, strpos($name, ' '));
				return true;
			}
		}
		else
			return false;
	}
	
	function checkSession() {
		if (!isset($_COOKIE['SESSION-ID'])) {
			session_unset();
			session_destroy();
			//setcookie('SESSION-ID', $userMD5, time() + 5, '/');
			//header("Location :'."$_SERVER['PHP_SELF']."'");
			//header("Location: {$_SERVER['HTTP_REFERER']}");
			/*else
				session_regenerate_id(true);*/
		}
	}
	
?>