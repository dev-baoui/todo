<?php
session_start();
if (isset($_POST)) {
	require 'core.php';
	$userinfo = DB::Query('SELECT * FROM users WHERE token=?', [$_SESSION['user_token']]);
	$userinfo = $userinfo->fetch(PDO::FETCH_ASSOC);
	if ($_POST['do']=='add') {
		$data = [
			'user_id' => $userinfo['id'],
			'title' => htmlentities(trim($_POST['title'])),
			'added_date' => date('Y-m-d H:i:s', time()),
			'priority' => htmlentities(trim($_POST['priority'])),
			'dead_end' => htmlentities(trim($_POST['timeInterval']))
		];
		$q = DB::Query('INSERT INTO tasks (user_id, title, added_date, priority, dead_end) VALUES (:user_id, :title, :added_date, :priority, :dead_end)', $data);
		if ($q) {
			echo "success";
		}else{
			echo "Something went wrong!";
		}
	}elseif ($_POST['do']=='done' || $_POST['do']=='undone') {
		if (isset($_POST['id'])) {
			$done = 1;
			if ($_POST['do']=='undone') {
				$done = 0;
			}
			$data = [
				'done' => $done,
				'id' => htmlentities(trim($_POST['id'])),
				'user_id' => $userinfo['id']
			];
			$q = DB::Query('UPDATE tasks SET done=:done WHERE id=:id AND user_id=:user_id', $data);
			if ($q) {
				echo "success";
			}else{ echo "Something went wrong!";}
		}else{ echo "What are you trying to do !!"; }
	}else{
		echo "What are you trying to do !!";
	}
}
?>