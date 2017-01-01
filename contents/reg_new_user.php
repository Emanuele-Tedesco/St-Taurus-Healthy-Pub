<?php
	require 'functions.php';
	//include 'err_log.php';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    $_SESSION['reg-posted'] = TRUE;
		
		class User {
			public $name;
			//public $cf;
			public $tel;
			public $email;
			public $passwrd;
			public $address;
			public $vegetarian;
			public $vegan;
			
			public function __construct($name, /*$cf,*/ $tel, $email, $passwrd, $address, $vegetarian, $vegan) {
				$this->name = $name;
				//$this->cf = $cf;
				$this->tel = $tel;
				$this->address = $address;
				$this->email = $email;
				$this->passwrd = $passwrd;
				$this->vegetarian = $vegetarian;
				$this->vegan = $vegan;
			}
			
			public function printData () {
				echo $this->name.'<br />';
				//echo $this->cf.'<br />';
				echo $this->tel.'<br />';
				echo $this->address.'<br />';
				echo $this->email.'<br />';
				echo $this->passwrd.'<br />';
				echo $this->vegetarian.'<br />';
				echo $this->vegan.'<br />';
			}
		}
	}
			
	if (isset($_POST['vegetarian'])) {
		$vegetarian = 1;
	}
	else {
		$vegetarian = 0;
	}
	
	if (isset($_POST['vegan'])) {
			$vegan = 1;
	}
	else {
			$vegan = 0;
	}
			
	$new_user = new User(rtrim(ltrim($_POST['name'])), /*$_POST['cf'],*/ $_POST['tel'], $_POST['email'], SHA1($_POST['repasswrd']), rtrim(ltrim($_POST['address'])), $vegetarian, $vegan);
	
	if ($conn = open_db_connection()) {
		$query = "call add_user('$new_user->name', $new_user->tel, '$new_user->email', '$new_user->passwrd', '$new_user->address', $new_user->vegetarian, $new_user->vegan)";
		if ($conn->query($query)/* or die ('Err: ' . $conn->error)*/) {
			$_SESSION['reg-email'] = $new_user->email;
			$_SESSION['reg-ok'] = sendActivationMail ($new_user->name, $new_user->email);
		}
		else {
			$_SESSION['reg-ok'] = $conn->errno;
			$query = "call update_ai();";
			$conn->query($query);// or die ('Err: ' . $conn->error);
		}
		$conn->close();
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}	
	
	//$new_user->printData();
	
?>