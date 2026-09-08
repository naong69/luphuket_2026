<?php

$msg="";
if (isset($_POST["userName"])) {
$userid=$_POST["userName"];
$password=$_POST["userPassword"];

if($userid == 'admin' && $password == 'admin@luphuket'){	
	header('Location: ./backend.php?login=secure');
	die();
} else {
	
	 $msg='<div class="alert alert-danger text-center" role="alert">
		  <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
		  Invalid username or password
		</div>';

}


}
?>
<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin Back End</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<style type="text/css">
	@import url(http://fonts.googleapis.com/css?family=Roboto:400);
	body {
	  background-color:#fff;
	  -webkit-font-smoothing: antialiased;
	  font: normal 14px Roboto,arial,sans-serif;
	}
	
	.container {
		padding: 25px;
		position: fixed;
		width: 100%
	}

	.form-login {
		background-color: #EDEDED;
		padding-top: 10px;
		padding-bottom: 20px;
		padding-left: 20px;
		padding-right: 20px;
		border-radius: 15px;
		border-color:#d2d2d2;
		border-width: 5px;
		box-shadow:0 1px 0 #cfcfcf;
	}

	h4 { 
	 border:0 solid #fff; 
	 border-bottom-width:1px;
	 padding-bottom:10px;
	 text-align: center;
	}

	.form-control {
		border-radius: 10px;
	}

	.wrapper {
		text-align: center;
	}
	
	div.err {
		margin-top: 20px;
	}

</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-3">
            <div class="form-login">
            <h4>Welcome back.</h4>
			<form action="" method="POST" role="form" onsubmit="return validateForm()">
			<div class="form-group" id="form-group-userName">
            <input type="text" id="userName" name="userName" class="form-control input-sm chat-input" placeholder="username" />
            </div>
			</br>
			<div class="form-group" id="form-group-userPassword">
            <input type="password" id="userPassword" name="userPassword" class="form-control input-sm chat-input" placeholder="password" />
            </div>
			</br>
            <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary btn-md" name="btn-login" >login<i class="fa fa-sign-in"></i></button>
            </span>
			</form>
            </div>
            </div>
        <div class="err">
		<?php
			echo $msg;
		?>
		</div>
        </div>
    </div>
</div>
<script src="../js/bootstrap.min.js"></script>
<script>
function validateForm(){

if($('#userName').val()==""){
	$('#form-group-userName').addClass("has-error");
	return false;
} else {
	$('#form-group-userName').removeClass("has-error");
}

if($('#userPassword').val()==""){
	$('#form-group-userPassword').addClass('has-error');
	return false;
} else {
	$('#form-group-userPassword').removeClass('has-error');
}

}
</script>
</body>
</html>
<?php

?>