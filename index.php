<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome</title>
	<link href="https://fonts.googleapis.com/css?family=Sacramento" rel="stylesheet">
	<link rel="shortcut icon" href="icon.png">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<?php
		require 'core/MobileDetect/Mobile_Detect.php';
		$detect = new Mobile_Detect;
		if ($detect->isMobile()){ ?>
			<link rel="stylesheet" href="css/phone.css">
		<?php }else{ ?>
			<link rel="stylesheet" href="css/style.css">
		<?php }
	?>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<p>TODO</p>
		</div>
		<ul class="container-content">
			<?php if (isset($_SESSION['user_token']) AND $_SESSION['user_token']!=""): ?>
				<?php
					require 'core/core.php';
					$userinfo = DB::Query('SELECT * FROM users WHERE token=?', [$_SESSION['user_token']]);
				if ($userinfo->rowCount()!=0): ?>
						<?php
						$userinfo = $userinfo->fetch(PDO::FETCH_ASSOC);
						$ut = DB::Query('SELECT * FROM tasks WHERE user_id=? AND done=0 ORDER BY added_date DESC', [$userinfo['id']]);
						if ($ut->rowCount()==0) {
							$usertasks = "You don't have any tasks yet";
						}
						while ($t =$ut->fetch(PDO::FETCH_ASSOC)) {
							$usertasks[] = $t;
						}
					?>
					<div class="top-bar">
						<p onclick="SignOut()"><?= $userinfo['username'] ?></p>
					</div>
					<li class="error"></li>
					<li class="add-post">
						<div>
							<i class="fa fa-close close" onclick="hideAddTask()"></i>
							<input type="text" class="ap-title" placeholder="Title">
							<!-- Priority -->
							<select class="priority">
								<option value="0">Priority</option>
								<option value="1">*</option>
								<option value="2">**</option>
								<option value="3">***</option>
							</select>
							<!-- Time Interval -->
							<select class="time-interval">
								<option value="0">Time Interval</option>
								<option value="1">One Week</option>
								<option value="2">Two Weeks</option>
								<option value="3">One Month</option>
								<option value="4">Two Months</option>
							</select>
							<button class="submit btn" onclick="AddTask()">Add</button>
						</div>
						<button class="add btn" onclick="getAddTask()">Add Task</button>
						<div style="clear: both;"></div>
					</li>
					<?php if (!is_array($usertasks)): ?>
						<li class="tasks-empty">
							<p class="title"><?= $usertasks ?></p>
						</li>
					<?php else: ?>
						<?php foreach ($usertasks as $k => $v): ?>
								<li id="<?= $v['id'] ?>">
									<?php
										// Priority Colors
										$priority="blue";
										if ($v['priority']==2){$priority="green";}
										elseif ($v['priority']==3){$priority="red";}

										// Priority div's content

										// done thingy
										$done = "fa-circle-o";
										if ($v['done']==1){$done="fa-check-circle-o";}
										?>
									<div class="importance <?= $priority ?>"><!-- <p>2days left</p> --></div>
									<p class="title"><?= $v['title'] ?></p>
									<?php if ($v['done']==0): ?>
										<i onclick="taskDone(<?= $v['id'] ?>)" class="check-icon fa <?= $done ?>"></i>
									<?php else: ?>
										<i onclick="taskUnDone(<?= $v['id'] ?>)" class="check-icon fa <?= $done ?>"></i>
									<?php endif ?>
								</li>
						<?php endforeach ?>
					<?php endif ?>
				<?php else: ?>
					<li class="error"></li>
					<li class="login">
						<p class="kinda-header">Sign In</p>
						<input type="text" class="input luname" placeholder="username">
						<input type="password" class="input lpass" placeholder="password">
						<p class="up-link" onclick="getSignUp()">New user ?</p>
						<button class="btn btn-blue login-btn" onclick="signIn()">Sign In</button>
					</li>
					<li class="signup" style="display: none;">
						<p class="kinda-header">Sign Up</p>
						<div class="input-group">
							<input type="text" class="input suname" placeholder="username">
							<input type="password" class="input spass" placeholder="password">
						</div>
						<input type="email" class="input smail" placeholder="Email">
						<p class="up-link" onclick="getSignIn()">Already member</p>
						<button class="btn btn-blue signup-btn" onclick="signUp()">Sign Up</button>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</div>
</body>
</html>