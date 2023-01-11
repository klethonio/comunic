<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 2)){
?>
            <div class="bloco form" style="display:block">
            	<div class="titulo">Cadastrar novo artigo:</div>
<?php
if(!empty($_POST['sendForm'])){

	$f['title'] = $_POST['title'];
	$f['tags'] = $_POST['tags'];
	$f['content'] = ($_POST['content']);
	$f['date'] = date('Y-m-d H:i:s');
	$f['category'] = $_POST['category'];
	$f['cat_parent'] = getCat($f['category'], 'id_parent');
	$f['level'] = $_POST['level'];
	$f['status'] = $_POST['sendForm'] == 'Salvar' ? '0' : '1';
	$f['author'] = $_SESSION['adUser']['id'];
	$f['type'] = 'post';
	$thumb = $_POST['cover'];
	
	if(!in_array('', $f)){
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
		if($_FILES['thumb']['tmp_name']){
			$folder = '../uploads/';
			$year = date('Y');
			$month = date('m');
			if(!file_exists($folder.$year)){
				mkdir($folder.$year);
			}
			if(!file_exists($folder.$year.'/'.$month)){
				mkdir($folder.$year.'/'.$month);
			}
			if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $thumb['name'], $ext)){
				$f['thumb'] = $year.'/'.$month.'/'.$f['url'].$ext[0];
				uploadImage($thumb['tmp_name'], $f['url'].$ext[0], 865, $folder.$year.'/'.$month.'/');			
			}else echo '<span class="ms al">Formato da imagem inváido, atualize o artigo com uma nova imagem!</span>';
		}elseif($_POST['cover']){
			$folder = '../uploads/';
			$year = date('Y');
			$month = date('m');
			if(!file_exists($folder.$year)){
				mkdir($folder.$year);
			}
			if(!file_exists($folder.$year.'/'.$month)){
				mkdir($folder.$year.'/'.$month);
			}
			$thumb = $_POST['cover'];
			if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $thumb, $ext)){
				$f['thumb'] = $year.'/'.$month.'/'.$f['url'].$ext[0];
				uploadImage($_POST['cover'], $f['url'].$ext[0], 865, $folder.$year.'/'.$month.'/');			
			}else echo '<span class="ms al">Formato da imagem inváido, atualize o artigo com uma nova imagem!</span>';
		}
		if(create('cuc_posts', $f, 'ssssssssssss')){
			if($f['status'] == 1){
				echo '<span class="ms ok">Artigo criado com sucesso! Você pode vizualizá-lo ';
				echo '<a href="'.BASE.'/artigo/'.$f['url'].'" target="_blank" title="ver artigo">aqui</a>.</span>';
			}else{
				echo '<span class="ms in">Artigo criado com sucesso! Para ativá-lo clique ';
				echo '<a href="'.BASE.'/admin/index2.php?url=posts/posts" title="ver artigo">aqui</a>.</span>';
				echo '</span>';
			}
			unset($f);
			unset($thumb);
		}else echo '<span class="ms no">Error: Cadastro não realizado!</span>';
		
	}else echo '<span class="ms al">Preencha todos os campos!</span>';
		
}
?>                
                <form name="formulario" action="" method="post" enctype="multipart/form-data">
                	<label class="line">
                    	<span class="data">Capa:</span>
                        <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
                    	<span class="data">Url:</span>
                        <input type="text" name="cover" value="<?=$thumb ?? null?>" />
                    	<span class="obs">Obs.: Você pode enviar uma imagem ou passar a url. Certifique-se de que a imagem tenha uma dimensão de no mínimo 865 pixels de lagura para uma boa qualidade.</span>
                    </label>
                    <label class="line">
                    	<span class="data">Título:</span>
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
                        <select name="category">
                        <option disabled selected>Selecione a categoria:</option>
<?php
		$readParentCat = read('cuc_categories', 'WHERE id_parent IS NULL');
		if($readParentCat){
			foreach($readParentCat as $parentCat){
				echo '<option disabled>'.$parentCat['name'].'</option>';
				$readSubCat = read('cuc_categories','WHERE id_parent=?', array($parentCat['id']), 'i');
				if($readSubCat){
					foreach($readSubCat as $subCat){
						echo '<option value="'.$subCat['id'].'"';
						if($subCat['id'] == ($f['category'] ?? null)) echo 'selected';
						echo '>&raquo;&raquo; '.$subCat['name'].'</option>';
					}
				}else echo '<option disabled>Cadastre uma subcategoria aqui.</option>';
			}
		}else echo '<option disabled>Sem categorias.</option>';
?>
                        </select>
                    </label>
                    <div class="check">
                    	<span class="data">Permissão do artigo:</span>
                        <ul>
                            <li><label><input type="radio" value="0" name="level" <?php if(!empty($f['level'])) echo 'checked'; ?>/> Livre</label></li>
                            <li><label><input type="radio" value="4" name="level" <?php if(($f['level'] ?? null) == 4) echo 'checked'; ?>/> Leitor</label></li>
                            <li class="last"><label><input type="radio" value="3" name="level" <?php if(($f['level'] ?? null) == 3) echo 'checked'; ?>/> Premium</label></li>
                        </ul>
                    </div>
                    <input type="reset" value="Limpar" class="btnalt" />
                    <input type="submit" value="Salvar" name="sendForm" class="btnalt" />
                    <input type="submit" value="Salvar e Publicar" name="sendForm" class="btn" />
                    
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