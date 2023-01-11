<title><?=SITENAME?> - Fale Conosco</title>
<meta name="title" content="<?=SITENAME?> - Fale Conosco" />
<meta name="description" content="Entre em contato com a equipe <?=SITENAME?>" />
<meta name="keywords" content="contato, fale conosco, entre em contato, suporte" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE?>/contato" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="form">
	<h1 class="pgtitulo">Fale conosco</h1>
    
    <div class="left">
    	<h2>Dúvidas, criticas ou sugestões?</h2>
        <p>Nosso setor de atendimento está sempre pronto para ouvir você. Contudo pedimos que envie sua mensagem e aguarde!</p>
        <p>Temos uma grande quantidade de mensagens por dia. Mas damos a você a garantia do atendimento mais ágil possível. Nossas respostas
        são dadas em no máximo 48horas úteis.</p>
        <p>Deixe sua dúvida, critica ou sugestão aqui. Nossa equipe vai dar o melhor para lhe responder com a melhor solução.</p>
        <p><strong>Você ainda pode entrar em contato por outros canais:</strong></p>
        <p><strong>Telefone:</strong> <?=TEL?></p>
        <p><strong>Endereço:</strong>  <?=ADDRESS?></p>
    </div><!-- //left -->
    
    <div class="right">  
<?php
	if(!empty($_POST['sendForm'])){
		$f['name'] = $_POST['name'];
		$f['email'] = $_POST['email'];
		$f['subject'] = $_POST['subject'];
		$f['message'] = $_POST['message'];
		
		if(in_array('', $f)){
			echo '<p class="erro">Erro: Para sua mensagem ser enviada, preencha todos os campos!</p>';
		}elseif(!validMail($f['email'])){
			echo '<p class="erro">Erro: O e-mail que você informou tem formato inválido!</p>';
		}else{
			$message = '<div style=" font:14px \'Trebuchet MS\', Arial, Helvetica, sans-serif;">';
			$message .= '<p style="color:#333;">'.nl2br(strip_tags($f['message'])).'</p><hr/>';
			$message .= '<h3>Nova mensagem via contato do site - '.SITENAME.'</h3>';
			$message .= '<p><strong>Nome: </strong>'.$f['name'].'</p>';
			$message .= '<p><strong>Email: </strong>'.$f['email'].'</p>';
			$message .= '<p><strong>Assunto: </strong>'.$f['subject'].'</p>';
			$message .= '<p><strong>Data: </strong>'.date('d/m/Y H:i').'</p>';
			$message .= '<p><strong>Mensagem: </strong></p></div>';
			if(sendMail($f['subject'], $message, MAILUSER, SITENAME, MAILUSER, SITENAME, $f['email'], $f['name'])){
				$_SESSION['retunr'] = '<p class="accept">Obrigado por entrar em contato com '.SITENAME.', em breve entraremos em contato!</p>';
				header('Location: '.BASE.'/pagina/contato');
			}
		}
	}elseif(!empty($_SESSION['retunr'])){
		echo $_SESSION['retunr'];
		unset($_SESSION['retunr']);
	}
?>
    	<form name="contato" action="" method="post">
        	<fieldset>
            	<legend>Entre em contato</legend>
            	<label>
                	<span class="tt">Nome</span>
                    <input type="text" name="name" value="<?=$f['name'] ?? null?>">
                </label>
                <label>
                	<span class="tt">E-mail</span>
                    <input type="text" name="email" value="<?=$f['email'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Assunto</span>
                    <input type="text" name="subject" value="<?=$f['subject'] ?? null?>">
                </label>
                <label>
                	<span class="tt">Mensagem</span>
                    <textarea name="message" rows="8"><?=$f['message'] ?? null?></textarea>
                </label>
            </fieldset>
            <input type="reset" value="Limpar Campos" class="reset">
            <input type="submit" value="Enviar Contato" name="sendForm" class="btn">
        </form>
    </div><!-- //right -->
</div><!-- /form -->
</div><!-- //content -->