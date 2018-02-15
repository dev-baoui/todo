<?php
session_start();
unset($_SESSION['user_token']);
if (isset($_POST)) {
	require 'core.php';

	// User signIn
	if ($_POST['do']=='in') {
		$data = [
			'username' => htmlentities(trim($_POST['username'])),
			'password' => sha1(htmlentities(trim($_POST['password'])))
		];
		$q = DB::Query('SELECT token,blocked FROM users WHERE username=:username AND password=:password', $data);
		if ($q->rowCount()==1) {
			$q = $q->fetch(PDO::FETCH_ASSOC);
			if ($q['blocked']==0) {
				$_SESSION['user_token'] = $q['token'];
				echo "success";
			}else{
				echo "user Blocked!";
			}
		}else{
			echo "Incorrect information!";
		}
	}

	// User signUp
	elseif ($_POST['do']=='up') {
		$data = [
			'username' => htmlentities(trim($_POST['username'])),
			'email' => htmlentities(trim($_POST['email'])),
			'password' => sha1(htmlentities(trim($_POST['password']))),
			'up_date' => date('Y-m-d H:i:s', time()),
			'token' => bin2hex(openssl_random_pseudo_bytes(32))
		];
		$q = DB::Query('SELECT token,blocked FROM users WHERE username=:username', ['username' => $data['username']]);
		if ($q->rowCount()==1) {
			echo "username already used";
		}else{
			$up = DB::Query('INSERT INTO users (username, email, password, up_date, token) VALUES (:username, :email, :password, :up_date, :token)', $data);
			if ($up) {
				$_SESSION['user_token'] = $data['token'];
				echo "success";
			}else{ echo "Something went wrong!"; }
		}
	}

	// User signOut
	elseif ($_POST['do']=='out') {
		if (isset($_SESSION['user_token'])) {
			unset($_SESSION['user_token']);
		}
	}
	
	// others cases
	else{
		echo "What are you trying to do !!";
	}
}else{
	echo "What are you trying to do !!";
}
?>