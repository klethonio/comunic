<?php
ob_start();
session_start();
require('../dts/dbaSis.php');
require('../dts/othSis.php');

if(!empty($_SESSION['adUser'])){
	header('Location: index2.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Painel Administrativo - <?=SITENAME?></title>

<meta name="title" content="Painel Administrativo - <?=SITENAME?>" />
<meta name="description" content="Área restrita aos administradores do site <?=SITENAME?>" />
<meta name="keywords" content="Login, Recuperar Senha, <?=SITENAME?>" />

<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE?>/admin" />
   
<meta name="language" content="pt-br" /> 
<meta name="robots" content="NOINDEX,NOFOLLOW" /> 

<link rel="icon" type="image/png" href="ico/chave.png" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="stylesheet" type="text/css" href="css/geral.css" />

</head>

<body>
<div id="login">
	<div class="login-logo">
    	<div class="band"></div>
    	<h2>Comunic Notícias</h2>
    </div>
	<?php
	$sendLogin = filter_input(INPUT_POST, 'sendLogin', FILTER_DEFAULT);
	if($sendLogin){
		$f['mail'] = ($_POST['mail']);
		$f['pswd'] = ($_POST['password']);
		$f['remember'] = ($_POST['remember']);
		
		if($f['mail'] && $f['pswd']){
			if(validMail($f['mail'])){
				if($readUser = read('cuc_users', "WHERE email = '$f[mail]'")){
					foreach($readUser as $user);
					if(encPswd($f['pswd']) == $user['pswd']){
						if($user['level'] == 1 || $user['level'] == 2){
							if($f['remember']){
								$cookie = base64_encode($f['mail']).'&'.base64_encode($f['pswd']);
								setcookie('adUser', $cookie, time()+60*60*24*30);
							}else{
								setcookie('adUser', "", time()-3600);
							}
							$_SESSION['adUser'] = $user;
							header('Location: '.$_SERVER['PHP_SELF']);
						}else{
							echo '<span class="ms al">Nível de usuário não permitido! Será redirecionado</span>';
							header('Refresh: 3; url="'.BASE.'/pagina/login"');
						}
					}else echo '<span class="ms no">Senha incorreta!</span>';
				}else echo '<span class="ms no">E-mail incorreto!</span>';
			}else echo '<span class="ms al">Digite um E-mail válido!</span>';
		}else echo '<span class="ms al">Preencha todos os campos!</span>';
		

	}elseif(!empty($_COOKIE['adUser'])){
		$cookie = explode('&', $_COOKIE['adUser']);
		$f['mail'] = base64_decode($cookie[0]);
		$f['pswd'] = base64_decode($cookie[1]);
		$f['remember'] = 1;
	}
	?>
    <?php
	if(empty($_GET['remember'])){
	?>
    <form name="login" action="" method="post">
        <label>
            <span>E-mail:</span>
            <input type="text" class="radius" name="mail" value="<?=$f['mail'] ?? null?>"/>
        </label>
        <label>
            <span>Senha:</span>
            <input type="password" class="radius" name="password" value="<?=$f['pswd'] ?? null?>"/>
        </label>
        <input type="submit" value="Logar-se" name="sendLogin" class="btn" />
        
        <div class="remember">
            <input type="checkbox" name="remember" value="1" <?php if(!empty($f['remember'])){echo 'checked';}?>/> Lembrar meus dados de acesso!
        </div>
        <a href="index.php?remember=true" class="link">Esqueci minha senha!</a>
    </form>
    <?php
	}else{
		if($_POST['sendRecover']){
			$recover = ($_POST['email']);
			$readUser = read('cuc_users', 'WHERE email=?', array($recover),"s");
			if($readUser){
				foreach($readUser as $user);
				if($user['level'] == 1 || $user['level'] == 2){
					$key = sha1(uniqid(mt_rand(), true));
					$readRec = read('cuc_recover', 'WHERE email=?', array($recover), 's');
					if(update('cuc_users', array('code' => $key), 'WHERE email=?', array($recover), 'ss')){
						$msg = '<div style="font:\'Trebuchet MS\', Arial, Helvetica, sans-serif;">';
						$msg .= '<h3 style="color:#099;">Presado '.$user['name'].', recupere seu acesso!</h3>';
						$msg .= '<p style="color:#666">Estamos entrando em contato pois foi solicitado em nosso nível administrativo / editor a recuperação de dados de acesso. Para concluir o processo, caso essa operação tenha sido efetuada por você, clique no link abaixo!</p><hr/>';
						$msg .= '<p style="color:#069"><em><a href="'.BASE.'/admin/recover.php?key='.$key.'">CLIQUE AQUI</a></em></p><hr/>';
						$msg .= '<h3 style="color:#900;">Atenciosamente, <strong>'.SITENAME.'</strong></h3>';
						$msg .= '<p style="color:#666; font-size:12px;">enviada em: '.date('d/m/Y H:i:s').'</p></div>';
						if(sendMail('Recupere seus dados', $msg, MAILUSER, SITENAME, $user['email'], $user['name'])){
							echo '<span class="ms ok">Um e-mail foi enviado para <strong>'.$recover.'</strong> com instruções para o resgate da senha. Favor, verifque caixa de spam!</span>';
						}else{
							echo '<span class="ms no">Erro: Operação não realizada, entre em contato com nossa equipe!</span>';
						}
					}
				}else{
					echo '<span class="ms al">Nível de usuário não permitido! Será redirecionado</span>';
					header('Refresh: 3; url="'.BASE.'/pagina/login"');
				}
			}else{
				echo '<span class="ms no">Error: E-mail não confere!</span>';
			}
		}
	?>
    <form name="recover" action="" method="post">
        <span class="ms in">Informe seu e-mail para que possamos enviar seus dados de acesso!</span>
        <label>
            <span>E-mail:</span>
            <input type="text" class="radius" name="email" value="<?=$recover?>" />
        </label>
        <input type="submit" value="Recuperar dados" name="sendRecover" class="btn" />
        <a href="index.php" class="link">Voltar</a>
    </form>
    <?php
	}
	?>
</div><!-- //login -->

</body>
<?php ob_end_flush(); ?>
</html>