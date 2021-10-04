<?php 
session_start(); 
if(isset($_SESSION["usuario"])){ 
	header("location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto GPDS</title>
	<meta name="description" content="UTA - Sistema de prestamo">
	<meta name="author" content="UTA">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<nav class="navbar navbar-default " role="navigation">
						<div class="navbar-header">
							<a class="navbar-brand" href="#">Bienvenido</a>
						</div>
					</nav>
					<div class="row">
						<div class="col-md-4">
						</div>
						<div class="col-md-4">
							<div id="wb_Form1" style="">
								<div style="text-align:center;"><img style="width:150px;" src="img/logo.png"></div><hr>
								<form role="form" method="post" id="uta-form-login" action="includes/control.php" autocomplete="off">
									<div class="form-group" id="error-container">
									</div>
									<div class="form-group">
										<label for="usuario">Usuario</label>
										<input type="text" class="form-control uta-user-id" placeholder="Ingresa tu usuario..." name="usuario" id="usuario" autofocus="true" required/>
									</div>
									<div class="form-group">
										<label for="password">Contraseña</label>
										<input type="password" class="form-control uta-user-password" placeholder="Ingresa tu contraseña..." name="clave" id="password" required/>
									</div>
									<div class="form-group">
										<button type="submit" style="min-width:100%;" class="btn btn-success uta-btn-login">Aceptar</button>
									</div>
								</form><hr>
							</div>
						</div>
						<div class="col-md-4">
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="js/jquery_x.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
		<script src="js/jquery_x.validate.js"></script>
		
		<script>
			(function(){
				$("#uta-form-login").submit(function(e){
					if($(this).valid()){
						
						authSanmex();
						return false;
					}else{
						e.preventDefault();
					}
				});
			})();
			function authSanmex(){
				var _user = $(".uta-user-id").val();
				var _pass = $(".uta-user-password").val();
				var _continueUrl = $("#continue_url_value").val();
				var _reCaptcha = $("#reCaptchaValidator").length === 1 ? true : false;
				var _data = $("#reCaptchaValidator").length === 1 ? {usuario: _user, clave: _pass, recaptchaValidator:_reCaptcha, grecaptcha: grecaptcha.getResponse()} : {usuario: _user, clave: _pass};
				try{
					
					$(".uta-btn-login").text("Espere por favor...");
					$(".uta-btn-login").attr("disabled", true);
					$.ajax({
						url : 'includes/control.php',
						type:'post',
						cache: false,
						data: _data,
						dataType : 'json',
						success: function(response){
							if(response.status){
								console.log(response);
								window.location.href = response.continue;
								return true;
							}else{
								console.log(response);
								$(".uta-user-password").val('');
								$("#error-container").html('<div style="display:none;" class="alert alert-warning error-container-msg">'+response.message+'</div>');
								$(".uta-btn-login").attr("disabled", false);
								$(".uta-btn-login").text("Aceptar");
								$(".error-container-msg").fadeIn(90);
								return false;
							}
						},error: function(xhr, j, p){
							$("#error-container").html(xhr.responseText);
						}
					});
				}catch(e){
					console.log(e);
				}
			}
		</script>
	</body>
</html>