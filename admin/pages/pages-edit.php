<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
		$pageId = $_GET['pageid'];
		if($readPage = read('cuc_posts', "WHERE id=? AND type='page'", array($pageId), 'i')){
			foreach($readPage as $page);
		}else header('Location: ?url=pages/pages');
?>
            <div class="bloco form" style="display:block">
            	<div class="titulo">Editar pagina <span style="color: #900;"><?=$page['title']?></span>: <a href="?url=posts/categories" class="btnalt" style="float:right;">Voltar</a></div>
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
		if($f['url'] != $page['url']){
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
		if(update('cuc_posts', $f, 'WHERE id=?', array($pageId), 'ssssssssssi')){
			$_SESSION['return'] = '<span class="ms ok">Página atualizada com sucesso!</span>';
			header('Location: ?url=pages/pages');
		}else echo '<span class="ms no">Error: Edição não realizada!</span>';
		
	}else echo '<span class="ms al">Preencha todos os campos!</span>';
		
}
?>                
                <form name="formulario" action="" method="post" enctype="multipart/form-data">
                    <label class="line">
                    	<span class="data">Nome da Pagina:</span>
                        <input type="text" name="title" value="<?=$page['title']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Tags:</span>
                        <input type="text" name="tags" value="<?=$page['tags']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Conteúdo:</span>
                        <textarea name="content" class="editor" rows="10"><?=htmlspecialchars($page['content'])?></textarea>
                    </label>
                    <label class="line">
                    	<span class="data">Data:</span>
                        <input type="text" name="date" class="formDate" value="<?=date('d/m/Y H:i:s', strtotime($page['date']))?>" />
                    </label>
                    <input type="reset" value="Limpar" class="btnalt" />
                    <input type="submit" value="Atualizar" name="sendForm" class="btn" />
                    
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