<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
?>
            <div class="bloco form" style="display:block">
            	<div class="titulo">Publicar nova pagina:</div>
<?php
if(!empty($_POST['sendForm'])){

	$f['title'] = $_POST['title'];
	$f['tags'] = $_POST['tags'];
	$f['content'] = ($_POST['content']);
	$f['date'] = $_POST['date'];
	$f['category'] = '0';
	$f['level'] = '0';
	$f['status'] = '1';
	$f['author'] = $_SESSION['adUser']['id'];
	$f['type'] = 'page';
	
	if(!in_array('', $f)){
		$f['date'] = formDate($f['date']);
		$f['url'] = setUrl($f['title']);
		if($readPostUrl = read('cuc_posts', 'WHERE url LIKE ?', array('%'.$f['url'].'%'), 's')){
			for($i=1;;$i++){
				if($i == 1){
					if(!$readPostUrl = read('cuc_posts', 'WHERE url=?', array($f['url']), 's')){
						break;
					}
				}else{
					if(!$readPostUrl = read('cuc_posts', 'WHERE url=?', array($f['url'].'-'.$i), 's')){
						$f['url'] = $f['url'].'-'.$i;
						break;
					}				
				}
			}
		}
		if(create('cuc_posts', $f, 'ssssssssss')){
			echo '<span class="ms ok">Página criado com sucesso! Você pode vizualizá-la ';
			echo '<a href="'.BASE.'/sessao/'.$f['url'].'" target="_blank" title="ver página">aqui</a>.</span>';
		}else echo '<span class="ms no">Error: Cadastro não realizado!</span>';
		
	}else echo '<span class="ms al">Preencha todos os campos!</span>';
		
}
?>                
                <form name="formulario" action="" method="post" enctype="multipart/form-data">
                    <label class="line">
                    	<span class="data">Nome da Pagina:</span>
                        <input type="text" name="title" value="<?=$f['title'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Tags:</span>
                        <input type="text" name="tags" value="<?=$f['tags'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Conteúdo:</span>
                        <textarea name="content" class="editor" rows="10"><?=$f['content'] ?? null?></textarea>
                    </label>
                    <label class="line">
                    	<span class="data">Data:</span>
                        <input type="text" name="date" class="formDate" value="<?php if(!empty($f['date'])){ echo date('d/m/Y H:i:s', strtotime($f['date'])); }else echo date('d/m/Y H:i:s'); ?>" />
                    </label>
                    <input type="reset" value="Limpar" class="btnalt" />
                    <input type="submit" value="Publicar" name="sendForm" class="btn" />
                    
                </form>
                	
            </div><!-- /bloco form -->
<?php
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>