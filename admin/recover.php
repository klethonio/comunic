<?php
require('../dts/dbaSis.php');
require('../dts/othSis.php');
if($_GET['key']){
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
<meta name="url" content="<?=BASE?>/admin/recover.php" />
   
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
	$key = $_GET['key'];
	$pswd = substr(base64_encode(time().$key),0,10);
	$encPswd = encPswd($pswd);
	$readUser = read('cuc_users', 'WHERE code=?', array($key), 's');
	if($readUser){
		foreach($readUser as $user);
		$email = $user['email'];
		$msg = '<h3 style="font:16px \'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#099;">Presado '.$user['name'].', recupere seu acesso!</h3>';
		$msg .= '<p style="font: bold 12px Arial, Helvetica, sans-serif; color:#666">Sua senha foi resgatada com sucesso, segue abaixo uma nova senha para o acesso, modifique assim que possível!</p><hr/>';
		$msg .= '<p style="font:italic 12px \'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#069">Senha: <strong>'.$pswd.'</strong></p><hr/>';
		$msg .= '<p style="font: bold 12px Arial, Helvetica, sans-serif; color:#666">Atenciosamente a administração - '.date('d/m/Y H:i:s').' - <a style="color:#900" href="'.BASE.'">'.SITENAME.'</a></p>';
		if(update('cuc_users', array('pswd' => $encPswd, 'code' => NULL), 'WHERE email=?', array($email), 'sss')){
			if(sendMail('Recupere seus dados', $msg, MAILUSER, SITENAME, $email, $user['name'])){
				echo '<span class="ms ok">Um e-mail foi enviado para <strong>'.$email.'</strong> com sua nova senha. Favor, verifque caixa de spam!</span>';
			}else echo '<span class="ms no">Error: Tente novamente!</span>';
		}else echo '<span class="ms no">Error desconhecido: Tente mais tarde!</span><pre>';
	}else echo '<span class="ms no">Error: Chave não confere, repita a operação!</span>';
	echo '<a href="index.php?remember=true" class="link">Voltar</a>';
}else header('location: '.BASE.'/admin');
?>
</div>
</body>
</html>