<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
?>
			<div class="bloco form" style="display:block">
            	<div class="titulo">Criar categoria: <a href="?url=posts/categories" class="btnalt" style="float:right;">Voltar</a></div>
<?php
if(!empty($_POST['sendForm'])){
	$f['name'] = ($_POST['name']);
	$f['content'] = ($_POST['content']);
	$f['tags'] = ($_POST['tags']);
	$f['date'] = ($_POST['date']);
	if(!in_array(NULL, $f)){
		$f['date'] = formDate($f['date']);
		$f['url'] = setUrl($f['name']);
		if($readCatUrl = read('cuc_categories', 'WHERE url LIKE ?', array('%'.$f['url'].'%'), 's')){
			for($i=1;;$i++){
				if($i == 1){
					if(!$readCatUrl = read('cuc_categories', 'WHERE url=?', array($f['url']), 's')){
						break;
					}
				}else{
					if(!$readCatUrl = read('cuc_categories', 'WHERE url=?', array($f['url'].'-'.$i), 's')){
						$f['url'] = $f['url'].'-'.$i;
						break;
					}
				}
			}
		}
		if(create('cuc_categories', $f, 'sssss')){
			$_SESSION['return'] = '<span class="ms ok">Categoria criada com sucesso!</span>';
			header('Location: ?url=posts/categories');
		}
	}else{
		echo '<span class="ms al">Preencha todos os campos!</span>';
	}
}
?>
                <form name="formulario" action="" method="post">
                    <label class="line">
                    	<span class="data">Nome:</span>
                        <input type="text" name="name" value="<?=$f['name'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Descrição:</span>
                        <textarea name="content" style="resize:none;" rows="3"><?=$f['content'] ?? null?></textarea>
                    </label>
                    <label class="line">
                    	<span class="data">Tags:</span>
                        <input type="text" name="tags" value="<?=$f['tags'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Data:</span>
                        <input type="text" name="date" class="formDate" value="<?=date('d/m/Y H:i:s')?>" />
                    </label>
                    <input type="reset" value="clear" class="btnalt" />
                    <input type="submit" value="Criar" name="sendForm" class="btn" />
                </form>
                	
            </div><!-- /bloco form -->
<?php
	}else echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
}else header('Location: ../index2.php');
?>