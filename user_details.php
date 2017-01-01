<?php
	require_once 'contents/functions.php';
	require_once 'contents/err_log.php';
	if (isset($_SESSION['session-id'])) {
		if ($conn = open_db_connection()) {
			$query = "SELECT * FROM user WHERE id = ".$_SESSION['session-id'];
			if ($resultset = get_resultset($conn, $query)) { 
				$row = mysqli_fetch_assoc($resultset);
?>
<script src="js/user_details.js"></script><div class="container">
<div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="box">
            <div class="container-fluid">
                <div class="row">
                    <hr class="tagline-divider-large" />
                    <h2 class="intro-text text-center">I tuoi <strong>dati personali</strong></h2>
                    <hr class="tagline-divider-large" />
                </div>
            </div>
        <div class="container-fluid">
        <div class="row">
<?php 
	/*if (isset($_SESSION['user-details-updated']))
		include 'contents/registration_alert.php';*/
?>
        <form action="<?php echo htmlspecialchars('contents/update_user_details.php'); ?>" id="user_detail_form" method="post" role="form">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input disabled class="form-control" type="text" id="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input disabled class="form-control" type="mail" id="email" value="<?php echo $row['email']; ?>">
            </div>
            <div class="form-group">
                <label for="tel">Telefono:</label>
                <input disabled class="form-control" title="il numero di telefono può contenere solo numeri" pattern="[0-9]+" minlength="5" maxlength="10" type="text" name="tel" value="<?php echo $row['tel']; ?>">
            </div>
            <div class="form-group">
                <label for="addr">Indirizzo:</label>
                <input disabled class="form-control" maxlength="60" type="text" name="addr" value="<?php echo $row['address']; ?>">
            </div>
            <div class="checkbox">
                <label><input class="cb" disabled="true" type="checkbox" name="vegetarian" <?php if ($row['vegetarian']) echo ' checked'; ?> /> Vegetariano</label>
                <label><input class="cb" disabled="true" type="checkbox" name="vegan" <?php if ($row['vegan']) echo ' checked'; ?> /> Vegano</label>
                <br />
            </div>
            <div class="form-group text-right">
                <button type="button" id="mod-user-btn" class="btn btn-info">Modifica i tuoi dati</button>
                <button style="display: none;" id="save-mod-user-btn" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" style="color: white;"></span> Salva le modifiche</button>
            </div>
        </form>
	</div>
    <div class="col-md-2"></div>
</div>
</div>
</div>
</div>
</div>
<?php } } }
	else {
		$_SESSION['SESSION_TIMEOUT'] = true;
		echo '<meta http-equiv="refresh" content="0;URL=http://st-tauruspub.servebeer.com">';
	}
?>