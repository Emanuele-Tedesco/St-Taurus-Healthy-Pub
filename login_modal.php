<?php
	ini_set('session.use_only_cookies', true);
	session_start();
?>
<script src="js/login.js"></script>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <?php
			if (isset($_SESSION['reg-ok']) || isset($_SESSION['rec-pass']) || isset($_SESSION['login-action'])) {
				require 'contents/registration_alert.php';
				/*echo '<div id="registration-alert">';
				echo '<script type="text/javascript">load_reg_alert()</script>';
				echo '</div>';*/
			}
		?>
        <div class="modal-body" style="padding-bottom: 0;">
        	<form role="form" method="post" action="<?php echo htmlspecialchars("contents/login.php");?>" id="login-form">
        		<div class="form-group">
					<label for="username"><span class="glyphicon glyphicon-user"></span> Nome Utente</label>
					<input required type="email" class="form-control" name="username" placeholder="Email" />
				</div>
				<div class="form-group">
					<label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
					<input required type="password" class="form-control" name="password" placeholder="Password" />
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block" form="login-form" style="margin-bottom: 1em"><span class="glyphicon glyphicon-off"></span> Login</button>
                      <!--  <label for="remember-me">Ricordami</label>
                        <input type="checkbox" name="remember-me" />-->
                    </div>
                    <div class="col-md-6 text-right" style="margin-bottom: 1em">
                        <span style="padding-right:1.3em">Non sei registrato?</span><button form="" style="width:7.5em" class="btn btn-info" data-target="#registration-form" data-toggle="collapse">Registrati</button>
                    </div>
                </div>
			</form>
		</div>
		<div id="registration-form" class="modal-body collapse" style="margin-top: -1em">
        	<p><u>campi obbligatori</u> <span style="color: red;">*</span></p>
			<form id="reg-form" role="form" method="post" action="<?php echo htmlspecialchars("contents/reg_new_user.php");?>">
				<div class="form-group">
					<label for="name">Nome <span style="color: red;">*</span></label>
					<input required type="text" title="il nome può contenere solo lettere e spazi" pattern="[a-zA-Z\s]+" minlength="6" maxlength="50" class="form-control" name="name" placeholder="Nome & cognome"/>
				</div>
				<!--<div class="form-group">
					<label for="cf">Codice Fiscale</label>
					<input required type="text" title="il codice fiscale può contentere solo lettere o numeri" pattern="[a-zA-Z0-9\s]+" minlength="16" maxlength="16" class="form-control" name="cf" placeholder="Codice fiscale"/>
				</div>-->
				<div class="form-group">
					<label for="tel">Telefono <span style="color: red;">*</span></label>
					<input required type="text" title="il numero di telefono può contenere solo numeri" pattern="[0-9]+" minlength="5" maxlength="10" class="form-control" name="tel" placeholder="Telefono"/>
				</div>
				<div class="form-group">
					<label for="address">Indirizzo <span style="color: red;">*</span></label>
					<input required type="text" maxlength="60" class="form-control" name="address" placeholder="Indirizzo"/>
				</div>
				<div class="form-group">
					<label for="email">Email <span style="color: red;">*</span></label>
					<input required type="email" title="inserisci un indirizzo mail valido" minlength="6" maxlength="35" class="form-control" name="email" placeholder="Indirizzo email"/>
				</div>
				<div class="form-group">
					<label for="passwrd">Password <span style="color: red;">*</span></label>
					<input required id="passwrd" type="password" title="La password deve avere una lunghezza compresa tra i 6 e i 16 caratteri e contenere lettere MAIUSCOLE, minuscole e numeri e/o caratteri speciali" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="16" class="form-control" name="passwrd" placeholder="Password"/>
					<br />
					<input required id="repasswrd" data-toggle="tooltip" data-placement="auto" type="password" class="form-control" name="repasswrd" placeholder="Ripeti la password" onfocusout="passCheck()"/>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="vegetarian" /> Vegetariano</label>
					<label><input type="checkbox" name="vegan" /> Vegano</label>
					<br />
				</div>
                <div class="row text-center">
                    <button id="registration-button" type="submit" class="btn btn-success" data-toggle="modal"><span class="glyphicon glyphicon-ok" style="color: white;"></span> registrati</button>
                </div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><span class="glyphicon glyphicon-remove" style="color: white;"></span> Chiudi</button>
			<br /><p><a href="" data-target="#rec-pass-form" data-toggle="collapse">Password dimenticata?</a></p>
            <form class="collapse text-left inline-form" id="rec-pass-form" role="form" method="post" action="<?php echo htmlspecialchars("contents/rec_passwrd.php");?>">
			<div class="container-fluid">
            	<div class="row">
                    <label for="email">Email</label>
                    <input required="" class="form-control" type="email" title="inserisci un indirizzo mail valido" minlength="6" maxlength="35" name="email" placeholder="Indirizzo email utilizzato per la registrazione"><br>
                    <p class="text-center"><button type="submit" id="rec-passwrd-button" class="btn btn-warning"><span class="glyphicon glyphicon-share-alt" style="color: white;"></span> recupera la password</button></p>
                </div>
			</div>
		</div>
	</div>
</div>