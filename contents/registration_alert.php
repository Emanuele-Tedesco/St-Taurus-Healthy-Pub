<?php
	require_once 'contents/functions.php';
	//echo '<div class="alert alert-danger alert-dismissible fade in">';
	$X = '<a class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	$warning = '<div class="alert alert-warning alert-dismissible fade in">';
	$info = '<div class="alert alert-info alert-dismissible fade in">';
	$danger = '<div class="alert alert-danger alert-dismissible fade in">';
	if (isset($_SESSION['reg-ok'])) {
		switch ($_SESSION['reg-ok']) {
			case '1062':
				echo $warning.$X;
				echo '<p>'.$_SESSION['reg-ok'].': Email già registrata. Utilizzare un\'altra mail per la registrazione.</p>';
				break;
			case 'Mail Err':
				echo $danger.$X;
				echo '<p>Err: Si è verifica un errore durante il tentativo di invio della mail di conferma.</p>';
				echo '<p>Riprovare più tardi.</p>';
				break;
			default:
				echo $danger.$X;
				echo '<p>La richiesta ha generato un errore non previsto</p>';
				echo '<br/><p>Err: '.$_SESSION['reg-ok'].'</p>';
				break;
		}
		unset($_SESSION['reg-ok']);
	}
	else if (isset($_SESSION['rec-pass'])) {
		switch ($_SESSION['rec-pass']) {
			case 'active':
				echo $info.$X;
				echo '<p>E\' stato inoltrata una mail all\'indirizzo <strong>'.$_SESSION['user-mail'].'</strong> contenente le istruzioni per eseguire il cambio della password.</p>';
				unset ($_SESSION['user-mail']);
				break;
			case false:
				echo $warning.$X;
				echo '<p>L\'indirizzo email indicato non è registrato.</p>';
				break;
			case 'no-active':
				$name = $_SESSION['user-name'];
				$email = $_SESSION['user-mail'];
				echo $warning.$X;
				echo '<p>L\'account per il quale è stoto richiesto il cambio della password non è attivo.</p>';
				echo '<p>Devi procedere prima con l\'attivazione dell\'account.</p>';
				echo '<p>Se non dovessi aver ricevuto la mail di attivazione controlla nella cartella SPAM.</p>';
				echo '<p>Per ricevere nuovamente la mail di attivazione <a href="contents/functions.php?action='.rawurlencode(base64_encode('resend_act_mail')).'">clicca qui</a>.</p>';
				break;
			default:
				echo $danger.$X;
				echo '<p>La richiesta ha generato un errore non previsto</p>';
				break;
		}
		unset($_SESSION['rec-pass']);
	}
	else if (isset($_SESSION['login-action'])) {
		if ($_SESSION['login-action'] == 'no-match' ) {
			echo $danger.$X;
			echo '<p class="text-center">Nome utente e/o password errati</p>';
		}
		else if ($_SESSION['login-action'] == 'no-active') {
			echo $warning.$X;
			echo '<p class="text-center">L\'utente non è attivo</p>';
			echo '<p class="text-center">Devi procedere prima con l\'attivazione dell\'account.</p>';
			echo '<p class="text-center">Se non dovessi aver ricevuto la mail di attivazione controlla nella cartella SPAM.</p>';
			echo '<p class="text-center">Per ricevere nuovamente la mail di attivazione <a href="contents/functions.php?action='.rawurlencode(base64_encode('resend_act_mail')).'">clicca qui</a>.</p>';
		}
		unset ($_SESSION['login-action']);
	}
	else if (isset($_SESSION['user-details-updated'])) {
		unset($_SESSION['user-details-updated']);
		echo $info.$X.'<p>Profilo aggiornato correttamente</p></div>';		
		echo '<script type="application/javascript">dismissAlert();</script>';
	}
	echo '</div>';
?>