<div class="h60"></div>
<div class="container">
  	<div class="row">
    	<div class="col-md-offset-3 col-md-6 col-xs-12">
			<h1>Регистрация</h1>
			<?php if($data['errors']['server_error']){ ?>
				<div class="error_input">Прозошла ошибка, попробуйте позже.</div>
			<?php } ?>
			<form method="post">
				<div class="input-group input-group-lg wfull">
				  <span class="input-group-addon w150">Логин</span>
				  <input type="text" name="login" value="<?=$data['login']?>" class="form-control wfull">
				</div>
				<div class="error_input"><?=$data['errors']['login']?></div>
				<br />
				<div class="input-group input-group-lg wfull">
				  <span class="input-group-addon w150">Пароль</span>
				  <input type="password" name="password" value="<?=$data['password']?>"  class="form-control wfull">
				</div>
				<div class="error_input"><?=$data['errors']['password']?></div>
				<br />
				<div class="input-group input-group-lg wfull">
				  <input type="submit" name="submit" class="form-control btn btn-primary" value="Зарегистрироваться">
				</div>
			</form>
		</div>
	</div>
</div>