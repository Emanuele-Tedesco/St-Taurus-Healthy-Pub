<?php
	session_start();
	$redirect = '<meta http-equiv="refresh" content="4;URL=http://st-tauruspub.servebeer.com">';
	echo '<div class="modal-dialog">';
	//<button type="button" class="close" data-dismiss="modal">&times;</button>
	if (isset($_SESSION['message_type'])) {
		switch($_SESSION['message_type']) {
			case 'reg-ok':
				echo '<div class="alert alert-success alert-dismissible">';
				echo '<p><h4 class="text center">Registrazione avvenuta con successo!</h4></p>';
				echo '<p>Una mail di conferma è stata inviata all\'indirizzo <strong>'.$_SESSION['reg-email'].'</strong>.</p>';
				unset($_SESSION['reg-email']);
				echo '<p>Raggiungi il link in essa contenuto per confermare ed attivare il tuo account.</p>';
				echo '<p>Se non dovessi ricevere la mail controlla nella cartella SPAM.</p>';
				break;
			case 'act-ok':
				echo '<div class="alert alert-success alert-dismissible">';
				echo '<p><h4 class="text center">Ciao <strong>'.$_SESSION['user_name'].'</strong></h4></p>';
				unset($_SESSION['user_name']);
				echo '<p>Il tuo account è stato attivato con successo!</p>';
				echo $redirect;
				break;
			case 'act-ko':
				echo '<div class="alert alert-danger alert-dismissible text-center">';
				echo '<h4 class="text center">L\'account richiesto è già <strong>attivo</strong></h4>';
				echo $redirect;
				break;
		}
		unset($_SESSION['reg-ok'], $_SESSION['message_type']);
	}
	else if (isset($_SESSION['passwd-changed'])) {
		if ($_SESSION['passwd-changed']) {
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<p>La password è stata aggiornata correttamente.</h4></p>';
			echo $redirect;
		}
		else {
			echo '<div class="alert alert-danger alert-dismissible text-center">';
			echo '<h4 class="text center"><strong>Non</strong> è stato possibile ripristinare la password. Si prega di riprovare più tardi.</h4>';
			echo $redirect;
		}
		unset ($_SESSION['passwd-changed']);
	}
	else if (isset($_SESSION['SESSION_TIMEOUT'])) {
		echo '<div class="alert alert-info alert-dismissible text-center">';
		echo '<h4 class="text-center"><strong>Sessione scaduta</strong></h4>';
		echo '<p>Esegui nuovamente la Login...</p>';
		unset($_SESSION['SESSION_TIMEOUT']);
	}
	echo '</div></div>';
	/*echo '<script>close_modal_4();</script>';*/
?>