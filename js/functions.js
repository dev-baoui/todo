// Show the  addTaskform
function getAddTask(){
	$('.container-content .add-post div').slideDown(250);
	$('.add').slideUp(50);
}

// Hide the addTask form
function hideAddTask(){
	$('.container-content .add-post div').slideUp(250);
	$('.add').slideDown(250);
}

// AddTask
function AddTask(){
	var title = $('.add-post .ap-title').val();
	var priority = $('.add-post .priority').val();
	var timeInterval = $('.add-post .time-interval').val();
	if (title=="" || priority=="0" || timeInterval=="0") {
		$('.error').html('<p>All fields are required</p>');
		$('li.error').slideDown(600);
		setTimeout(function(){
			$('li.error').fadeOut(600);
		}, 4000);
	}else{
		$('.add-post .submit').html('<i id="loading" class="fa fa-circle-o-notch loading"></i>');
		$.post("core/task.php", {'title': title, 'priority': priority, 'timeInterval': timeInterval, 'do': 'add'}, function(data) {
	  		if (data=="success") {
				$('.add-post .submit').html('<i class="fa fa-check"></i>');
				hideAddTask();
				var color= "blue";
				if (priority==2) {color="green";}else if (priority==3) {color="red";}
				$('.add-post').after('<li><div class="importance '+color+'"></div><p class="title">'+title+'</p><i onclick="taskDone()" class="check-icon fa fa-circle-o"></i></li>');
				setTimeout(function(){
					$('.add-post .submit').html('Add');
				}, 1000);
				$('.add-post .ap-title').val("");
				$('.add-post .priority').val(0);
				$('.add-post .time-interval').val(0);
				$('.tasks-empty').fadeOut(150);
	  		}else{
	  			$('.error').html('<p>'+ data +'</p>');
				$('li.error').fadeIn(600);
				$('.add-post .submit').html('Add');
	  			setTimeout(function(){
					$('li.error').fadeOut(600);
				}, 4000);
	  		}
		});
	}
}


function taskDone(id){
	$.post("core/task.php", {'id': id, 'do': 'done'}, function(data){
		if (data=='success'){
			$('#'+id+' .check-icon').attr({'onclick': 'taskUnDone('+id+')', 'class': 'check-icon fa fa-check-circle-o'});
			$('.tasks-empty').hide();
			setTimeout(function(){
				$('#'+id).fadeOut(500);
			}, 1000);
		}else{
			$('.error').html('<p>'+ data +'</p>');
			$('li.error').fadeIn(600);
  			setTimeout(function(){
				$('li.error').fadeOut(600);
			}, 4000);
		}
	});
}

function taskUnDone(id){
	$.post("core/task.php", {'id': id, 'do': 'undone'}, function(data){
		if (data=='success'){
			$('#'+id+' .check-icon').attr({'onclick': 'taskDone('+id+')', 'class': 'check-icon fa fa-circle-o'});
		}else{
			$('.error').html('<p>'+ data +'</p>');
			$('li.error').fadeIn(600);
  			setTimeout(function(){
				$('li.error').fadeOut(600);
			}, 4000);
		}
	});
}


// Show the signUp form
function getSignUp(){
	$('.container-content .signup').show();
	$('.container-content .login').hide();
}

// Show the signIn form
function getSignIn(){
	$('.container-content .login').show();
	$('.container-content .signup').hide();
}

// Sign the user out
function SignOut(){
	$.post("core/sign.php", {'do': 'out'}, function() {
		location.reload();
	});
}


// Does the heavy work xD
function signIn(){
	var username = $('.login .luname').val();
	var password = $('.login .lpass').val();
	if (username=="" || password=="") {
		$('.error').html('<p>Both fields are required</p>');
		$('li.error').fadeIn(600);
		setTimeout(function(){
			$('li.error').fadeOut(600);
		}, 4000);
	}else{
		$('.login .login-btn').html('<i id="loading" class="fa fa-circle-o-notch loading"></i>');
		$.post("core/sign.php", {'username': username, 'password': password, 'do': 'in'}, function(data) {
	  		if (data=="success") {
				$('.login .login-btn').html('<i class="fa fa-check"></i>');
	  			location.reload();
	  		}else{
	  			$('.error').html('<p>'+ data +'</p>');
				$('li.error').fadeIn(600);
				$('.login .login-btn').html('Sign In');
	  			setTimeout(function(){
					$('li.error').fadeOut(600);
				}, 4000);
	  		}
		});
	}
}

function signUp(){
	var username = $('.signup .suname').val();
	var password = $('.signup .spass').val();
	var email = $('.signup .smail').val();
	if (username=="" || password=="" || email=="") {
		$('.error').html('<p>All fields are required</p>');
		$('li.error').fadeIn(600);
		setTimeout(function(){
			$('li.error').fadeOut(600);
		}, 4000);
	}else{
		$('.signup .signup-btn').html('<i id="loading" class="fa fa-circle-o-notch loading"></i>');
		$.post("core/sign.php", {'username': username, 'password': password, 'email': email, 'do': 'up'}, function(data) {
	  		if (data=="success") {
				$('.signup .signup-btn').html('<i class="fa fa-check"></i>');
	  			location.reload();
	  		}else{
	  			$('.error').html('<p>'+ data +'</p>');
				$('li.error').fadeIn(600);
				$('.signup .signup-btn').html('Sign Up');
	  			setTimeout(function(){
					$('li.error').fadeOut(600);
				}, 4000);
	  		}
		});
	}
}