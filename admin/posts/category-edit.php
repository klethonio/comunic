<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
		$idCat = ($_GET['catid']);
		if($readCat = read('cuc_categories', 'WHERE id=?', array($idCat), 'i')){
			foreach($readCat as $cat);
		}else header('Location: ?url=posts/categorias');
?>
			<div class="bloco form" style="display:block">
            	<div class="titulo">Editar categoria <span style="color: #900;"><?=$cat['name']?></span>: <a href="?url=posts/categories" class="btnalt" style="float:right;">Voltar</a></div>
<?php
if(!empty($_POST['sendForm'])){
	$f['name'] = ($_POST['name']);
	$f['content'] = ($_POST['content']);
	$f['tags'] = ($_POST['tags']);
	$f['date'] = ($_POST['date']);
	if(!in_array(NULL, $f)){
		$f['date'] = formDate($f['date']);
		if($prefix = read('cuc_categories', 'WHERE id=?', array($cat['id_parent']), 'i')){
			foreach($prefix as $prefix);
			$f['url'] = $prefix['url'].'-'.setUrl($f['name']);
		}else{
			$f['url'] = setUrl($f['name']);
			if($readSubCat = read('cuc_categories', 'WHERE id_parent=?', array($cat['id']), 'i')){
				foreach($readSubCat as $subCat){
					$subCatUrl = preg_replace('/^'.$cat['url'].'/', '',$subCat['url'], 1);
					$data = array('url' => $f['url'].$subCatUrl);
					update('cuc_categories', $data, 'WHERE id=?', array($subCat['id']), 'si');
				}
			}
		}
		if($f['url'] != $cat['url']){
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
		if(update('cuc_categories', $f, 'WHERE id=?', array($idCat), 'sssssi')){
			$_SESSION['return'] = '<span class="ms ok">Categoria atualizada com sucesso!</span>';
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
                        <input type="text" name="name" value="<?=$cat['name']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Descrição:</span>
                        <textarea name="content" style="resize:none;" rows="3"><?=$cat['content']?></textarea>
                    </label>
                    <label class="line">
                    	<span class="data">Tags:</span>
                        <input type="text" name="tags" value="<?=$cat['tags']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Data:</span>
                        <input type="text" name="date" class="formDate" value="<?=date('d/m/Y H:i:s', strtotime($cat['date']))?>" />
                    </label>
                    <input type="reset" value="clear" class="btnalt" />
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