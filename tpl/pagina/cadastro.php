<?php
if(!empty($_SESSION['adUser'])) header('Location: '.BASE.'/pagina/perfil');
if(!empty($url[3])){
	if($url[2] == 'ativar'){
		$codeAct = $url[3];
		$codeAct = explode('and', $codeAct);
		$emailAct = base64_decode($codeAct[0]);
		$pswdAct = base64_decode($codeAct[1]);
		if($readAct = read('cuc_users', 'WHERE email=? AND pswd=?', array($emailAct, $pswdAct), 'ss')){
			foreach($readAct as $act);
			if($act['status'] == 1){
				header('Location: '.BASE.'/sessao/erro-ao-ativar');
			}else{
				update('cuc_users', array('status' => 1), 'WHERE id=?', array($act['id']), 'is');
				header('Location: '.BASE.'/sessao/sucesso-ao-ativar');
			}
		}else echo 'erro ao ativar';
	}
}
?>
<title>Cadastro - <?=SITENAME?></title>
<meta name="title" content="Cadastro - <?=SITENAME?>" />
<meta name="description" content="Cadastro - <?=SITENAME?>" />
<meta name="keywords" content="cadastro, <?=SITENAME?>" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE?>/pagina/cadastro" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="form">
	<h1 class="pgtitulo">Participe:</h1>
    
    <div class="left">
    	<h2>Cadastre-se e participe de nossa rede de leitores.</h2>
        <p>Sendo um leitor cadastrado você tem acesso liberado a maioria dos nossos artigos e novidades.</p>
        <p>Alem de participar da rede e poder interagir em todos os artigos, expressando sua opnião e interagindo com os outros leitores!</p>
        <p>Existe ainda a conta premium. Onde você tem acesso a 100% do conteúdo do site, Colabora com a expansão do site e 
        tem coteúdo especial liberado para você!</p>
        <p><strong>Cadastre-se agora mesmo!</strong></p>
        <p>Tenha acesso ao melhor conteúdo informativo da internet!</p>
        <img src="<?=BASE?>/tpl/images/premium.png" title="Conta Premium" alt="Conta Premium">
    </div><!-- //left -->
    
    <div class="right">
<?php
if(!empty($_POST['sendForm'])){
	$f['name'] = $_POST['name'];
	$f['cpf'] = $_POST['cpf'];
	$f['email'] = $_POST['email'];
	$f['pswd'] = $_POST['pswd'];
	$repswd = $_POST['repswd'];
	$f['address'] = $_POST['address'];
	$f['cep'] = $_POST['cep'];
	$f['district'] = $_POST['district'];
	$f['city'] = $_POST['city'];
	$f['state'] = $_POST['state'];
	$f['cel'] = $_POST['cel'];
	
	$error = array();
	
	if(in_array('', $f) || !$repswd){
		$error[] = 'Erro: Para efetuar o cadastro, preencha todos os campos obrigatórios!';
	}
	if(!validMail($f['email']) && $f['email']){
		$error[] = 'Erro: O e-mail que você informou tem formato inválido!';
	}
	if(!validCPF($f['cpf']) && $f['cpf']){
		$error[] = 'Erro: O CPF que você informou não é inválido!';
	}
	if(($repswd != $f['pswd']) && $f['pswd'] && $repswd){
		$error[] = 'Erro: As senhas digitadas não são as mesmas!';
	}elseif((strlen($f['pswd']) < 6) && $f['pswd'] && $repswd){
		$error[] = 'Erro: A senha deve conter no mínimo 6 caracteres!';
	}
	if(($readEmail = read('cuc_users', 'WHERE email=?', array($f['email']), 's')) && $f['email']){
		$error[] = 'Erro: E-mail já cadastrado!';
	}
	if(($readCpf = read('cuc_users', 'WHERE cpf=?', array($f['cpf']), 's')) && $f['cpf']){
		$error[] = 'Erro: CPF já cadastrado!';
	}
	if($error){
		foreach($error as $val){
			echo '<p class="erro">'.$val.'</p>';
		}
	}else{
		$f['tel'] = $_POST['tel'];
		$f['pswd'] = encPswd($f['pswd']);
		$f['level'] = 4;
		$f['status'] = 0;
		$f['reg_date'] = date('Y-m-d H:i:s');
		if(create('cuc_users', $f, 'sssssssssssiis')){
			$linkAct = BASE.'/pagina/cadastro/ativar/'.base64_encode($f['email']).'and'.base64_encode($f['pswd']);
			$message = '<div style="font:\'Trebuchet MS\', Arial, Helvetica, sans-serif;">';
			$message .= '<h3 style="color:#09f">Prezado(a) '.$f['name'].', recebemos sua solicitação de cadastro!</h3>';
			$message .= '<p style="color:#333">Estamos entrando em contato devido à essa solicitação, de cadastro no site '.SITENAME.'. Caso essa operação não tenha sido efetuada por você, ignore esta mensagem.</p><hr/>';
			$message .= '<p style="color:#069">Para ativar sua conta, clique no link abaixo ou caso tenha problemas, copie a url e cole no seu navegador:</p>';
			$message .= '<p><a href="'.$linkAct.'">'.$linkAct.'</a></p>';
			$message .= '<h3 style="color:#900;">Atenciosamente, <strong>'.SITENAME.'</strong></h3>';
			$message .= '<p style="color:#666; font-size:12px;">enviada em: '.date('d/m/Y H:i:s').'</p></div>';
			sendMail('Ative sua conta - '.SITENAME, $message, MAILUSER, SITENAME, $f['email'], $f['name']);
			header('Location: '.BASE.'/sessao/ative-sua-conta');
		}
	}
}
?>
    	<form name="cadastro" action="" method="post">
        	<fieldset>
            	<legend>Identificação:</legend>
            	<label>
                	<span class="tt">Nome completo *</span>
                    <input type="text" name="name" value="<?=$f['name'] ?? null?>">
                </label>
                <label>
                	<span class="tt">CPF *</span>
                    <input type="text" class="formCpf" name="cpf" value="<?=$f['cpf'] ?? null?>">
                </label>
                <label>
                	<span class="tt">E-mail *</span>
                    <input type="text" name="email" value="<?=$f['email'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Senha *</span>
                    <input type="password" name="pswd" value="">
                </label>
                <label>
                	<span class="tt">Repitir Senha *</span>
                    <input type="password" name="repswd" value="">
                </label>
            </fieldset>
            
            <fieldset>
            	<legend>Endereço:</legend>
            	<label>
                	<span class="tt">Rua - Número *</span>
                    <input type="text" name="address" value="<?=$f['address'] ?? null?>">
                </label>
                <label>
                	<span class="tt">CEP *</span>
                    <input type="text" class="formCep" name="cep" value="<?=$f['cep'] ?? null?>">
                </label>
            	<legend>Bairro:</legend>
            	<label>
                	<span class="tt">Bairro *</span>
                    <input type="text" name="district" value="<?=$f['district'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Cidade *</span>
                    <input type="text" name="city" value="<?=$f['city'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Estado *</span>
                    <input type="text" name="state" value="<?=$f['state'] ?? null?>">
                </label>
            </fieldset>
            
            <fieldset>
            	<legend>Contato:</legend>
            	<label>
                	<span class="tt">Telefone</span>
                    <input type="text" class="formFone" name="tel" value="<?=$f['tel'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Celular *</span>
                    <input type="text" class="formFone" name="cel" value="<?=$f['cel'] ?? null?>">
                </label>
            </fieldset>
            <span class="obs">* Campos obrigatórios</span>
            <input type="reset" value="Limpar Campos" class="reset">
            <input type="submit" value="Cadastrar meus dados" name="sendForm" class="btn">
        </form>
    </div><!-- //right -->
    
</div><!-- /form -->
</div><!-- //content -->