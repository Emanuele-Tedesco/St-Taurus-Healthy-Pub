<?php
	ini_set('session.use_only_cookies', true);
	session_start();
	if (!isset($_SESSION['generated']) || $_SESSION['generated'] < (time() - 30 )) {
		session_regenerate_id(true);
		$_SESSION['generated'] = time();	
	}
	require_once 'contents/functions.php'
?>
<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<title>St Taurus Healthy Pub</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="St Taurus Pub Main Page">
		<meta name="author" content="Manu">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#5cb85c">
        <meta name="msapplication-navbutton-color" content="#5cb85c">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<link rel="icon" href="image/11046320_415985228611599_2232649313542420098_n.jpg">
		<link rel="stylesheet" type="text/css" href="css/t-index.css"> <!-- mio stylesheet -->
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> <!-- jquery -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
		<script src="js/st.js"></script> <!--miei script-->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script> <!-- angularjs -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script> <!-- angular route module --> 
		<script src="js/Lettering.js-master/jquery.lettering.js"></script> <!-- lettering -->
		<script src="js/CircleType-master/js/circletype.js"></script> <!-- circletype -->
	</head>
	<body ng-app="page-router">
		<!--Header-->
		<header class="container-fluid">
        	<div class="row text-center">
                <img class="image-responsive" id="head-main-logo" alt="St Taurus Logo" src="image/ribbonbanner4.png">
                <!--<h1 class="h1-head">St Taurus Healthy Pub</h1>-->
            </div>           
			<div class="row">
				<nav id="my-nav-bar" class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" title="Mostra/nascondi il menu" class="navbar-toggle nav-toggle">
							<span class="glyphicon glyphicon-th-list"></span>
						</button>
						<a href="#" class="home-button" title="Torna alla home"><span class="glyphicon glyphicon-home"></span></a>
					</div>
					<!--<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					</ul>-->
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown">I nostri menu <span class="caret"></span></a>
								<ul class="dropdown-menu inverted">
									<li class="no-dropdown">
										<a href="#menu_sala">Menu di sala</a>
									</li>
<?php
	if (isset($_SESSION['session-id']))
		echo '<li class="no-dropdown"><a href="#menu_asporto">Menu da asporto</a></li>';
	else
		echo '<li class="no-dropdown disabled"><a title="Per accedere devi essere autenticato">Menu da asporto</a></li>';
?>
								</ul>
							</li>
							<li class="no-dropdown">
								<a href="#filosofia" title="La nostra filosofia">La nostra filosofia</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="no-dropdown">
								<a href="#contatti"><span class="glyphicon glyphicon-map-marker"></span> Contatti</a>
							</li>
<?php
	if (isset($_SESSION['session-id'])) {
		echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"> Ciao '.$_SESSION['name'].'! <span class="caret"></span></a>';
		echo '<ul class="dropdown-menu inverted">';
		echo '<li class="no-dropdown"><a href="#user_details"><span class="glyphicon glyphicon-user"></span>&nbsp; Il tuo profilo</a></li>';
		echo '<li class="no-dropdown"><a href="contents/functions.php?action='.rawurlencode(base64_encode('session-close')).'"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>';
		echo '</ul>';
	}
	else
		echo '<li class="no-dropdown"><a data-toggle="modal" id="login-link"><span class="glyphicon glyphicon-log-in"></span>&nbsp; Login</a>';
	echo '</li>';
?>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<div ng-view></div>
		<footer>
			<div class="container-fluid">
				<div class="row text-center">
					<p>&copy; Copyright by <b>Emanuele Tedesco</b> 2017</p>
				</div>
			</div>
		</footer>
		<div class="modal fade" id="login-modal" role="dialog"></div>
		<div class="modal fade" role="dialog" id="message-modal"></div>
<?php
	if (isset($_SESSION['reg-posted'])) {
		unset($_SESSION['reg-posted']);
		if (isset($_SESSION['reg-ok'])) {
			if ($_SESSION['reg-ok'] == 'ok') {
				$_SESSION['message_type'] = 'reg-ok';
				echo '<script type="text/javascript">open_main_modal();</script>';
			}
			else {
				echo '<script type="text/javascript">force_open_login_modal(1);</script>';
			}	
		}
		if (isset($_SESSION['rec-pass']))
			echo '<script type="text/javascript">force_open_login_modal(0);</script>';
	}
	else if (isset($_GET['action'])) {
		switch (base64_decode($_GET['action'])) {
			case 'activate':
				if (activeUser($_GET['user'])) {
					$_SESSION['message_type'] = 'act-ok';
				}
				else
					$_SESSION['message_type'] = 'act-ko';
				break;
			default:
				break;
		}
		echo '<script type="text/javascript">open_main_modal();</script>';
	}
	else if (isset($_SESSION['login-action'])) {
		if ($_SESSION['login-action'] == 'no-match' || $_SESSION['login-action'] == 'no-active')
			echo '<script type="text/javascript">force_open_login_modal(0);</script>';
	}
	else if (isset($_SESSION['SESSION_TIMEOUT'])) {
		/*echo '<script type="text/javascript">clickReload();</script>';*/
		echo '<script type="text/javascript">open_main_modal();</script>';
	}
	/*else if (isset($_SESSION['REFRESH'])) {
		unset($_SESSION['REFRESH']);
		$_SESSION['SESSION_TIMEOUT'] = true;
		echo '<script type="text/javascript">clickReload();</script>';
		//echo '<script type="text/javascript">open_main_modal();</script>';
	}*/
?>
	</body>
</html>