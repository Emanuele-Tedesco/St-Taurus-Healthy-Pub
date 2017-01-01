<?php
	session_start();
	require 'contents/functions.php';
	if (isset($_GET['action']) && isset($_GET['user'])) {
echo '<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>St Taurus Healthy Pub - Reset Password</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="St Taurus Pub Main Page">
		<meta name="author" content="Manu">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="image/11046320_415985228611599_2232649313542420098_n.jpg">
		<link rel="stylesheet" type="text/css" href="css/t-index.css"> <!-- mio stylesheet -->
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> <!-- jquery -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
		<script src="js/st.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script> <!-- angularjs -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script> <!-- angular route module --> 
		<script src="js/Lettering.js-master/jquery.lettering.js"></script> <!-- lettering -->
		<script src="js/CircleType-master/js/circletype.js"></script> <!-- circletype -->
        <script src="js/login.js"></script>
	</head>
	<body>
		<header class="container-fluid">
			<div class="text-center">
				<img class="image-responsive" id="head-main-logo" alt="St Taurus Logo" src="image/ribbonbanner4.png">
			</div>
			<div class="row">
				<nav id="my-nav-bar" class="navbar navbar-inverse">
                	<div class="navbar-header"> 
                	<a href="http://st-tauruspub.servebeer.com" class="home-button" title="Torna alla home"><span class="glyphicon glyphicon-home"></span></a>
                    </div>
                	<a class="navbar-brand text-center">Recupero Password</a>
                </nav>
		  </div>
		</header>
		<div class="container">
        	<div class="col-md-3"></div>
        	<div class="col-md-6">
            	<div class="box">
                    <form id="change-pass-form" role="form" method="post" action="';

							if (isset($_GET['user'])) {
								echo htmlspecialchars('contents/change_passwd.php?action="'.rawurlencode(base64_encode('change-passwd')).'"&user="'.$_GET['user']);
							}

                        echo '">
                        <div class="form-group">
                            <label for="passwrd">Nuova Password</label>
                            <input required id="passwrd" type="password" title="La password deve avere una lunghezza compresa tra i 6 e i 16 caratteri e contenere lettere MAIUSCOLE, minuscole e numeri e/o caratteri speciali" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="16" class="form-control" name="passwrd" placeholder="Password"/>
                            <br />
                            <label for="passwrd">Riperti la Password</label>
                            <input required id="repasswrd" data-toggle="tooltip" data-placement="auto" type="password" class="form-control" name="repasswrd" placeholder="Ripeti la password" onfocusout="passCheck()"/>
                        </div>
                        <div class="form-group">
                            <div class="row text-center">
                            	<br/>
                                <button id="rec-passwd-button" type="submit" class="btn btn-success" data-toggle="modal"><span class="glyphicon glyphicon-ok" style="color: white;"></span> aggiorna la password</button>
                            </div>
                        </div>
                    </form>
                 </div>
              </div>
              <div class="col-md-3"></div>
           </div>
        </div>
		<!--<footer>
			<div class="container-fluid">
				<div class="row text-center">
					<p>
						<b>&copy; Copyright by Emanuele Tedesco</b>
					</p>
				</div>
			</div>
		</footer>-->
		<!--<div class="modal fade" id="login-modal" style="padding: !important padding: 1em height: 1.8em;" role="dialog"></div>-->
		<div class="modal fade" role="dialog" id="message-modal"></div>
	</body>';
    if (isset($_SESSION['passwd-changed']))
		echo '<script type="text/javascript">open_main_modal();</script>';
	echo '</html>';
	}
	else
		header("Refresh: 0; URL=not_found.php");
?>