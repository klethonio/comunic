<?php
if(!empty($_SESSION['adUser'])) header('Location: '.BASE.'/pagina/perfil');
?>
<title>Acessar minha conta - <?=SITENAME?></title>
<meta name="title" content="Acessar minha conta - <?=SITENAME?>" />
<meta name="description" content="Acessar conta e conferir o melhor conteúdo de notícias da internet" />
<meta name="keywords" content="<?=SITETAGS?>" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE?>/pagina/login" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">
<?php setArq('tpl/header'); ?>

<div id="content">
<?php
if(empty($url[2])){
?>
<div class="form">
	<h1 class="pgtitulo">Minha conta</h1>
    <div class="left">
    	<h2>Informe seus dados ao lado para acessar sua conta Leitor ou Premium.</h2>
        <p>Lembre-se de manter seus dados em segurança. Sua conta é de uso próprio e intranferivel, você pode alterar seus dados e migrar sua conta quando quiser. Basta acessar o sistema e interagir com o mesmo.</p>
        <p>Para reenviar o e-mail de ativação basta <a class="link" href="<?=BASE?>/pagina/login/reenviar" title="Recuperar senha">clicar aqui</a>!</p>
        <p>Caso tenha esquecido seus dados basta <a class="link" href="<?=BASE?>/pagina/login/recuperar" title="Recuperar senha">clicar aqui</a> para recuperar sua senha!</p>
    </div><!-- //left -->
    
    <div class="right">
<?php
	$sendLogar = filter_input(INPUT_POST, 'sendLogar', FILTER_DEFAULT);
	if($sendLogar){
		$f['email'] = $_POST['email'];
		$f['pswd'] = encPswd($_POST['pswd']);
		if(in_array('', $f)){
			echo '<p class="erro">Erro: Para efetuar o longin, preencha todos os campos!</p>';
		}elseif(!$readUser = read('cuc_users', 'WHERE email=? AND pswd=?', array($f['email'], $f['pswd']), 'ss')){
			echo '<p class="erro">Erro: E-mail e/ou senha inválido(s)!</p>';
		}else{
			foreach($readUser as $user);
			if($user['status'] == 0){
				echo '<p class="erro">Erro: Sua conta não está ativa! Favor verique seu e-mail.</p>';
			}else{
				$_SESSION['adUser'] = $user;
				header('Location: '.BASE.'/pagina/perfil');
			}
		}
	}
?>
    	<form name="contato" action="" method="post">
        	<fieldset>
            	<legend>Acessar</legend>
            	<label>
                	<span class="tt">E-mail</span>
                    <input type="text" name="email" value="<?=$f['email'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Senha</span>
                    <input type="password" name="pswd" value="">
                </label>
            </fieldset>
            <input type="submit" value="Entrar agora" name="sendLogar" class="btn">
        </form>
    </div><!-- //right -->
    
</div><!-- /form -->
<?php
}elseif($url[2] == 'recuperar'){
?>
<div class="form">
	<h1 class="pgtitulo">Recuperar senha:</h1>
    
    <div class="left">
    	<h2>Veja como é fácil recuperar sua senha:</h2>
        <p>Informe ao lado seu e-mail de acesso a nosso sistema e seu CPF e clique em recuperar dados.</p>
        <p>Se os dados forem corretos enviaremos um e-mail no endereço informado!</p>
        <p>Basta acessar seu e-mail e acessar o link contido no corpo da mensagem para redefinir sua senha.</p>
    </div><!-- //left -->
    
    <div class="right">
<?php
	if($_POST['sendRecover']){
		$f['email'] = $_POST['email'];
		$f['cpf'] = $_POST['cpf'];
		if(in_array('', $f)){
			echo '<p class="erro">Erro: Para recuperar a senha, preencha todos os campos!</p>';
		}elseif(!$readUser = read('cuc_users', 'WHERE email=? AND cpf=?', array($f['email'], $f['cpf']), 'ss')){
			echo '<p class="erro">Erro: E-mail e/ou cpf inválido(s) ou não pertencem a mesma conta!</p>';
		}else{
			foreach($readUser as $user);
			if($user['status'] == 0){
				echo '<p class="erro">Erro: Sua conta não está ativa! Favor verique seu e-mail.</p>';
			}else{
				$key = sha1(uniqid(mt_rand(), true));
				if(update('cuc_users', array('code' => $key), 'WHERE email=?', array($user['email']), 'ss')){
					$linkRec = BASE.'/pagina/login/alterar/'.$key;
					$message = '<div style="font:\'Trebuchet MS\', Arial, Helvetica, sans-serif;">';
					$message .= '<h3 style="color:#099;">Presado '.$user['name'].', recupere seu acesso!</h3>';
					$message .= '<p style="color:#666">Estamos entrando em contato pois foi solicitado em nosso sistema a recuperação de dados de acesso. Para concluir o processo, caso essa operação tenha sido efetuada por você, clique no link abaixo ou caso tenha problemas, cole a url no seu navegador!!</p><hr/>';
					$message .= '<p style="color:#069"><em><a href="'.$linkRec.'">'.$linkRec.'</a></em></p><hr/>';
					$message .= '<h3 style="color:#900;">Atenciosamente, <strong>'.SITENAME.'</strong></h3>';
					$message .= '<p style="color:#666; font-size:12px;">enviada em: '.date('d/m/Y H:i:s').'</p></div>';
					if(sendMail('Recupere seus dados', $message, MAILUSER, SITENAME, $user['email'], $user['name'])){
						echo '<span class="accept">Um e-mail foi enviado para <strong>'.$user['email'].'</strong> com instruções para o resgate da senha. Favor, verifque caixa de spam!</span>';
						unset($f);
					}else{
						echo '<p class="erro">Erro: Operação não realizada, entre em contato com nossa equipe!</p>';
					}
				}
			}
		}
	}
?>
        <form name="contato" action="" method="post">
        	<fieldset>
            	<legend>Recuperar:</legend>
            	<label>
                	<span class="tt">E-mail:</span>
                    <input type="text" name="email" value="<?=$f['email']?>">
                </label>
                <label>
                	<span class="tt">CPF:</span>
                    <input type="text" class="formCpf" name="cpf" value="<?=$f['cpf']?>">
                </label>
            </fieldset>
            <input type="submit" value="Receber dados" name="sendRecover" class="btn">
        </form>
    </div><!-- //right -->
    
</div><!-- /form -->
<?php
}elseif($url[2] == 'alterar' && $url[3]){
?>
<div class="form">
	<h1 class="pgtitulo">Alterar senha:</h1>
    <div class="left">
    	<h2>Olá, você deve informar uma nova senha:</h2>
        <p>Está página está sendo exibida porque você solicitou uma recuperação de dados.</p>
        <p>Para concluir essa alteração você deve informar sua nova senha ao lado!</p>
        <p>Lembre-se: A senha deve ter de 8 a 12 caracteres.</p>
    </div><!-- //left -->
    
    <div class="right">
<?php
	$key = $url[3];
	if($readUser = read('cuc_users', 'WHERE code=?', array($key), 's')){
		if($_POST['sendPswd']){
			$f['pswd'] = $_POST['pswd'];
			$repswd = $_POST['repswd'];
			if(!$f['pswd'] || !$repswd){
				echo '<p class="erro">Erro: Para recuperar a senha, preencha todos os campos!</p>';
			}elseif(strlen($f['pswd']) < 6){
				echo '<p class="erro">Erro: A senha deve conter no mínimo 6 caracteres!</p>';
			}elseif($f['pswd'] != $repswd){
				echo '<p class="erro">Erro: As senhas digitadas não são as mesmas!</p>';
			}else{
				foreach($readUser as $user);
				$f['pswd'] = encPswd($f['pswd']);
				$f['code'] = NULL;
				if(update('cuc_users', $f, 'WHERE id=?', array($user['id']), 'ssi')){
					echo '<p class="accept">Sua senha foi alterada com sucesso, se diriga para a área de login!</p>';
					$validRecover = true;
				}
			}
		}
		if(!$validRecover){
?>
        <form name="contato" action="" method="post">
        	<fieldset>
            	<legend>Alterar senha:</legend>
            	<label>
                	<span class="tt">Nova senha:</span>
                    <input type="password" name="pswd" value="">
                </label>
                <label>
                	<span class="tt">Repita a nova senha:</span>
                    <input type="password" name="repswd" value="">
                </label>
            </fieldset>
            <input type="submit" value="Alterar minha senha" name="sendPswd" class="btn">
        </form>
<?php
		}
	}else echo '<p class="erro">Chave de validação invalida! Por favor, reenvie o formulario de ativação. Caso o erro persista entre em contato com nossa equipe.</p>';
?>
    </div><!-- //right -->
    
</div><!-- /form -->
<?php
}elseif($url[2] == 'reenviar'){
?>
<div class="form">
	<h1 class="pgtitulo">Reenviar e-mail de ativação:</h1>
    
    <div class="left">
    	<h2>Olá, você deve informar seu e-mail:</h2>
        <p>Está página está sendo exibida porque você solicitou um reenvio de e-mail para ativação.</p>
        <p>Para concluir esse processo você deve informar seu e-mail ao lado!</p>
        <p>Lembre-se: Caso seja um e-mail inválido, efetue o cadastro com um e-mail válido.</p>
    </div><!-- //left -->
    
    <div class="right">
<?php
	if($_POST['sendResend']){
		$f['email'] = $_POST['email'];
		$f['cpf'] = $_POST['cpf'];
		if($readUser = read('cuc_users', 'WHERE email=? AND cpf=?', $f, 'ss')){
			foreach($readUser as $user);
			if($user['status'] == 0){
				$linkAct = BASE.'/pagina/cadastro/ativar/'.base64_encode($user['email']).'and'.base64_encode($user['pswd']);
				$message = '<div style="font:\'Trebuchet MS\', Arial, Helvetica, sans-serif;">';
				$message .= '<h3 style="color:#09f">Prezado(a) '.$user['name'].', recebemos sua solicitação de cadastro!</h3>';
				$message .= '<p style="color:#333">Estamos entrando em contato novamente devido à essa solicitação, de cadastro no site '.SITENAME.'. Caso essa operação não tenha sido efetuada por você, ignore esta mensagem.</p><hr/>';
				$message .= '<p style="color:#069">Para ativar sua conta, clique no link abaixo ou caso tenha problemas, copie a url e cole no seu navegador:</p>';
				$message .= '<p><a href="'.$linkAct.'">'.$linkAct.'</a></p>';
				$message .= '<h3 style="color:#900;">Atenciosamente, <strong>'.SITENAME.'</strong></h3>';
				$message .= '<p style="color:#666; font-size:12px;">enviada em: '.date('d/m/Y H:i:s').'</p></div>';
				if(sendMail('Ative sua conta - '.SITENAME, $message, MAILUSER, SITENAME, $f['email'], $f['name'])){
					 echo '<p class="accept">Reenvio de e-mail de ativação realizado, acesse seu e-mail. Favor, verifque caixa de spam!</p>';
				}else echo '<p class="erro">Erro: Operação não realizada, entre em contato com nossa equipe!</p>';
			}else echo '<p class="erro">Erro: Este usuário ja está ativado, se diriga para a área de login!</p>';
		}else echo '<p class="erro">Erro: E-mail e/ou cpf inválido(s) ou não pertencem a mesma conta!</p>';
	}
?>
        <form name="contato" action="" method="post">
        	<fieldset>
            	<legend>Reenviar:</legend>
            	<label>
                	<span class="tt">E-mail:</span>
                    <input type="text" name="email" value="<?=$f['email']?>">
                </label>
                <label>
                	<span class="tt">CPF:</span>
                    <input type="text" class="formCpf" name="cpf" value="<?=$f['cpf']?>">
                </label>
            </fieldset>
            <input type="submit" value="Receber dados" name="sendResend" class="btn">
        </form>
    </div><!-- //right -->
    
</div><!-- /form -->
<?php
}else header('Location: '.BASE);
?>
</div><!-- //content -->