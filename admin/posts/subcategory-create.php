<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
		$idCat = ($_GET['catid']);
		if($readCat = read('cuc_categories', 'WHERE id=?', array($idCat), 'i')){
			foreach($readCat as $cat);
		}else header('Location: ?url=posts/categorias');
?>
			<div class="bloco form" style="display:block">
            	<div class="titulo">Criar subcategoria para <span style="color: #900;"><?=$cat['name']?></span>: <a href="?url=posts/categories" class="btnalt" style="float:right;">Voltar</a></div>
<?php
if(!empty($_POST['sendForm'])){
	$f['name'] = ($_POST['name']);
	$f['content'] = ($_POST['content']);
	$f['tags'] = ($_POST['tags']);
	$f['date'] = ($_POST['date']);
	
	if(!in_array(NULL, $f)){
		$f['id_parent'] = $idCat;
		$f['date'] = formDate($f['date']);
		$f['url'] = $cat['url'].'-'.setUrl($f['name']);
		if($readCatUrl = read('cuc_categories', 'WHERE url LIKE ?', array('%'.$f['url'].'%'), 's')){
			for($i=1;;$i++){
				if(!$readCatUrl = read('cuc_categories', 'WHERE url=?', array($f['url'].'-'.$i), 's')){
					$f['url'] = $f['url'].'-'.$i;
					break;
				}
			}
		}
		if(create('cuc_categories', $f, 'ssssiss')){
			$_SESSION['return'] = '<span class="ms ok">Sub-categoria criada com sucesso!</span>';
			header('Location: ?url=posts/categories');
		}
	}else{
		echo '<span class="ms al">Preencha todos os campos!</span>';
	}
	echo '<pre class="debug">';
	print_r($f);
	echo '</pre>';
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
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>