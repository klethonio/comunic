<?php
if(function_exists('getUser')){
	if(!getUser($_SESSION['adUser']['id'], 4)) header('Location: '.BASE.'/sessao/acesso-restrito');
}else header('Location: '.BASE.'/pagina/perfil');

if(!$readUser = read('cuc_users', 'WHERE id=?', array($_SESSION['adUser']['id']), 'i')){
	unset($_SESSION['adUser']);
	setcookie('adUser', "", time()-3600);
	header('Location: '.BASE.'/pagina/login');
}else{
	foreach($readUser as $user);
	if($user['status'] == 0) header('Location: '.BASE.'/sessao/acesso-restrito');
}
?>
<title>Perfil - <?=SITENAME?></title>
<meta name="title" content="Perfil - <?=SITENAME?>"/>
<meta name="description" content="Dados do leitor"/>
<meta name="keywords" content="perfil, dados, alterar dados, <?=SITETAGS?>"/>
<meta name="author" content="Klethônio Ferreira"/>
<meta name="url" content="<?=BASE?>/pagina/pefil"/>
<meta name="language" content="pt-br"/>
<meta name="robots" content="NOINDEX,NOFOLLOW"/> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="form">
	<h1 class="pgtitulo">Bem vindo ao seu perfil, <?=substr($user['name'], 0, strpos($user['name'], ' '))?>!</h1>
    
    <div class="left" style="float:right;">
    	<h2>Confira e atualize seu avatar</h2>
        <p>Seu atavar em nosso site atualmente é:</p>
<?php
$author = getAut($user['id']);
?>
        <img src="<?=BASE.'/tim.php?src='.$author['avatar']?>&w=80&h=80" title="<?=$author['name']?>">
        <p>Deseja alterar este avatar?</p>
<?php
if(!empty($_POST['sendAvatar'])){
	$newAvatar = $_FILES['img'];
	$tmp = $newAvatar['tmp_name'];
	$folder = 'uploads/avatars/';
	if (!is_dir($folder)) {
		mkdir($folder);
	}
	if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $newAvatar['name'], $ext)){
		$name = md5(time()).$ext[0];
		if(file_exists($folder.$user['avatar']) && is_file($folder.$user['avatar'])){
			unlink($folder.$user['avatar']);
		}
		uploadImage($tmp, $name, 200, $folder);
		update('cuc_users', array('avatar' => $name), 'WHERE id=?', array($user['id']), 'si');
		header('Location: '.BASE.'/pagina/perfil');
	}else echo '<p class="erro">Erro: Arquivo não é uma imagem!</p>';
}
?>
        <form name="avatar" action="" method="post" enctype="multipart/form-data">
        	<label style="width:320px;">
        		<input type="file" name="img" style="width:290px;"/>
            </label>
            <input type="submit" name="sendAvatar" value="Enviar Avata" class="btn"/>
        </form>
        <br />
<?php
switch($user['level']){
	case 1: $level = 'ADMINISTRADOR'; break;
	case 2: $level = 'EDITOR'; break;
	case 3: $level = 'MEMBRO'; break;
	case 4: $level = 'LEITOR'; break;
	default: $level = 'ERROR';
}
?>
        <p style="font:bold 20px Verdana, Geneva, sans-serif; color:#0CF; margin:0;"><?=$level?></p>
    </div><!-- //left -->
    
    <div class="right" style="float:left;">
<?php
if(!empty($_POST['sendForm'])){
	$f['pswd'] = $_POST['pswd'];
	$repswd = $_POST['repswd'];
	if(!$f['pswd'] || !$repswd){
		echo '<p class="erro">Erro: Para alterar a senha, preencha os dois campos!</p>';
	}elseif(strlen($f['pswd']) < 6){
		echo '<p class="erro">Erro: A senha deve conter no mínimo 6 caracteres!</p>';
	}elseif($f['pswd'] != $repswd){
		echo '<p class="erro">Erro: As senhas digitadas não são as mesmas!</p>';
	}else{
		$f['pswd'] = encPswd($f['pswd']);
		update('cuc_users', $f, 'WHERE id=?', array($user['id']), 'si');
		$_SESSION['adUser']['pswd'] = $f['pswd'];
		$_SESSION['return'] = '<p class="accept">Sua senha foi alterada com sucesso!</p>';
		header('Location: '.BASE.'/pagina/perfil');
	}
}elseif(!empty($_SESSION['return'])){
	echo $_SESSION['return'];
	unset($_SESSION['return']);
}
?>
    	<form name="cadastro" action="" method="post">
        	<fieldset>
            	<legend>Identificação</legend>
            	<label>
                	<span class="tt">Nome completo</span>
                    <span class="campos"><?=$user['name']?></span>
                </label>
                <label>
                	<span class="tt">CPF</span>
                     <span class="campos">xxx.xxx.xxx-<?=substr($user['cpf'], -2)?></span>
                </label>
                <label>
                	<span class="tt">E-mail</span>
                    <span class="campos"><?=$user['email']?></span>
                </label>
            </fieldset>
            
            <fieldset>
            	<legend>Endereço</legend>
            	<label>
                     <span class="campos"><?=$user['address'].' - '.$user['cep'].'<br/>'.$user['district'].' - '.$user['city'].' - '.$user['state']?></span>
                </label>
            </fieldset>
            
            <fieldset>
            	<legend>Contato</legend>
            	<label>
                	<span class="tt">Telefone / Celular:</span>
                    <span class="campos"><?php if($user['tel']) echo $user['tel'].' / '; ?><?=$user['cel']?></span>
                </label>
            </fieldset>
            <fieldset>
            	<legend>Alterar Senha</legend>
            	<label>
                	<span class="tt">Nova senha:</span>
                    <input type="password" name="pswd">
                </label>
                <label>
                	<span class="tt">Repita sua nova senha</span>
                    <input type="password" name="repswd">
                </label>
            </fieldset>
            <input type="submit" value="Atualizar senha" name="sendForm" class="btn">
        </form>
    </div><!-- //right -->
    
</div><!-- /form -->
</div><!-- //content -->