<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
		if(!empty($_POST['sendFilter'])){
			$_SESSION['search'] = $_POST['search'];
			if($_SESSION['search']){
				$_SESSION['where'] = ' AND title LIKE ? ';
				header('Location: ?url=pages/pages');
			}else{
				unset($_SESSION['search']);
				unset($_SESSION['where']);
			}
		}
?>
            <div class="bloco pag" style="display:block">
            	<div class="titulo">Páginas:   
                <form name="filtro" action="" method="post">
<?php
		if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
			echo '<span class="searchInfo">Buscas sobre: <span style="text-transform:uppercase">'.$_SESSION['search'].'</span> <input type="submit" value="Voltar" style="margin:-4px -2px -4px 0" name="sendFilter" class="btn" /></span>';
		}else{
?>
                    	<label>
                        	<input type="text" name="search" class="radius" size="30" placeholder="Titulo:"/>
                        </label>
                        <input type="submit" value="filtrar resultados" name="sendFilter" class="btn" />
<?php	} ?>
                    </form>
                </div><!-- /titulo -->
<?php
if(!empty($_SESSION['return'])){
	echo $_SESSION['return'];
	unset($_SESSION['return']);
}
		$pag = $_GET['pag'] ?? 1;
		if(!empty($_GET['delpage'])){
			if($readGallery = read('cuc_gallery', 'WHERE post_id=?', array($_GET['delpage']), 'i')){
				foreach($readGallery as $gallery){
					if(file_exists('../uploads/'.$gallery['img']) && is_file('../uploads/'.$gallery['img'])){
						unlink('../uploads/'.$gallery['img']);
					}
				}
				delete('cuc_gallery', 'WHERE post_id=?', array($_GET['delpage']), 'i');
			}
			delete('cuc_posts', 'WHERE id=?', array($_GET['delpage']), 'i');
			header('Location: ?url=pages/pages&pag='.$pag);
		}
		$max = 5;
		$start = ($pag-1)*$max;
		if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
			$params = array('%'.$_SESSION['search'].'%', $start, $max);
			$values = 'sii';
		}else{
			$params = array($start, $max);
			$values = 'ii';
		}
		if($readArt = read('cuc_posts', "WHERE type='page'".($_SESSION['where'] ?? '').'ORDER BY date DESC LIMIT ?, ?', $params, $values)){
?>                    
                <table width="560" border="0" class="tbdados" style="float:left;" cellspacing="0" cellpadding="0">
                  <tr class="ses">
                    <td>nome:</td>
                    <td>resumo:</td>
                    <td align="center">tags:</td>
                    <td align="center">criada:</td>
                    <td align="center" colspan="3">ações:</td>
                  </tr>
<?php
			foreach($readArt as $art){
				$artTags = $art['tags'] ? 'ok.png' : 'no.png';
?>
                  <tr>
                    <td><a href="<?=BASE.'/sessao/'.$art['url']?>" title="<?=$art['title']?>" target="_blank"><?=resText($art['title'], 20)?></a></td>
                    <td><?=resText(strip_tags($art['content']), 30)?></td>
                    <td align="center"><img src="ico/<?=$artTags?>" alt="<?=$art['tags']?>" title="<?=$art['tags']?>" /></td>
                    <td align="center"><?=date('d/m/y H:i', strtotime($art['date']))?></td>
                    <td align="center"><a href="?url=pages/pages-edit&pageid=<?=$art['id']?>" title="editar"><img src="ico/edit.png" alt="editar" title="editar" /></a></td>
                    <td align="center"><a href="?url=pages/gallery&pageid=<?=$art['id']?>" title="postar galeria"><img src="ico/gb.png" alt="postar galeria" title="postar galeria" /></a></td>
                    <td align="center"><a href="#window-del" rel="?url=pages/pages<?='&pag='.$pag.'&delpage='.$art['id']?>" title="excluir"><img src="ico/no.png" alt="excluir" title="excluir" /></a></td>
                  </tr>
<?php
			}
        echo '</table>';
			$url = '?url=pages/pages&pag=';
			if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
				$params = array('%'.$_SESSION['search'].'%');
				$types = 's';
			}else{
				$params = NULL;
				$types = NULL;
			}
			paginator('cuc_posts', "WHERE type='page'".($_SESSION['where'] ?? '')."ORDER BY date DESC", $params, $types, $max, $url, $pag);
?>
            </div><!-- /bloco pag -->
            <span class="ms al" id="window-del">
                <p>Atenção: Você está prestes a excluir uma página. Deseja continuar?</p>
                <p style="text-align:center;"><a class="btnalt" name="excluir" href="#">SIM</a> <a class="close-del btn">NÃO</a></p>
            </span>
            <div id="mask"></div>
<?php
		}elseif($pag == 1){
			echo '<span class="ms in">Não foram encontradas páginas!</span>';
		}else header('Location: ?url=pages/pages');

	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>