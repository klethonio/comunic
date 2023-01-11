<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 2)){
		if(!empty($_POST['sendFilter'])){
			$_SESSION['search'] = $_POST['search'];
			if($_SESSION['search']){
				$_SESSION['where'] = ' AND title LIKE ? ';
				header('Location: ?url=posts/posts');
			}else{
				unset($_SESSION['search']);
				unset($_SESSION['where']);
			}
		}
?>
<div class="bloco list" style="display:block">
            	<div class="titulo">Artigos:
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
		$max = 10;
		$start = ($pag-1)*$max;
		if(!empty($_GET['atart'])){
			$readSt = read('cuc_posts', 'WHERE id=?', array($_GET['atart']), 'i');
			foreach($readSt as $status);
			$status = $status['status'] == 0 ? 1 : 0;
			$data = array('status' => $status);
			update('cuc_posts', $data, 'WHERE id=?', array($_GET['atart']), 'ii');
			header('Location: ?url=posts/posts&pag='.$pag);
		}elseif(!empty($_GET['delart'])){
			$readThumb = read('cuc_posts', 'WHERE id=?', array($_GET['delart']), 'i');
			if($readGallery = read('cuc_gallery', 'WHERE post_id=?', array($_GET['delart']), 'i')){
				foreach($readGallery as $gallery){
					if(file_exists('../uploads/'.$gallery['img']) && is_file('../uploads/'.$gallery['img'])){
						unlink('../uploads/'.$gallery['img']);
					}
				}
				delete('cuc_gallery', 'WHERE post_id=?', array($_GET['delart']), 'i');
			}
			foreach($readThumb as $thumb);
			$thumb = $thumb['thumb'];
			if(file_exists('../uploads/'.$thumb) && is_file('../uploads/'.$thumb)){
				unlink('../uploads/'.$thumb);
			}
			delete('cuc_posts', 'WHERE id=?', array($_GET['delart']), 'i');
			header('Location: ?url=posts/posts&pag='.$pag);
		}
		if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
			$params = array('%'.$_SESSION['search'].'%', $start, $max);
			$values = 'sii';
		}else{
			$params = array($start, $max);
			$values = 'ii';
		}
		if($readArt = read('cuc_posts', "WHERE type='post'".($_SESSION['where'] ?? '').'ORDER BY date DESC LIMIT ?, ?', $params, $values)){
?>                   
                <table width="560" border="0" class="tbdados" style="float:left;" cellspacing="0" cellpadding="0">
                  <tr class="ses">
                    <td>titulo:</td>
                    <td align="center">data:</td>
                    <td align="center">categoria:</td>
                    <td align="center">visitas:</td>
                    <td align="center" colspan="4">ações:</td>
                  </tr>
<?php
			foreach($readArt as $art){
				$getCat = getCat($art['category']);
				$stIco = $art['status'] == 0 ? 'alert.png' : 'ok.png';
				$stTitle = $art['status'] == 0 ? 'ativar' : 'desativar';
?>
                  <tr>
                    <td><a href="<?=BASE.'/artigo/'.$art['url']?>" title="<?=$art['title']?>" target="_blank"><?=resText($art['title'], 35)?></a></td>
                    <td align="center">
						<span title="<?php if($art['update_date']) echo 'Atualizado em: '.date('d/m/Y H:i', strtotime($art['update_date']))?>"><?=date('d/m/y H:i', strtotime($art['date']))?></span>
                    </td>
                    <td align="center"><a target="_blank" href="<?=BASE.'/categoria/'.$getCat['url']?>" title="<?=$getCat['url']?>"><?=$getCat['name']?></a></td>
                    <td align="center"><?=$art['views']?></td>
                    <td align="center"><a href="?url=posts/posts-edit&artid=<?=$art['id']?>" title="editar"><img src="ico/edit.png" alt="editar" title="editar" /></a></td>
                    <td align="center"><a href="?url=posts/gallery&artid=<?=$art['id']?>" title="postar galeria"><img src="ico/gb.png" alt="postar galeria" title="postar galeria" /></a></td>
                    <td align="center"><a href="?url=posts/posts<?='&pag='.$pag.'&atart='.$art['id']?>" title="<?=$stTitle?>"><img src="ico/<?=$stIco?>" alt="<?=$stTitle?>" title="<?=$stTitle?>" /></a></td>
                    <td align="center"><a href="#window-del" rel="?url=posts/posts<?='&pag='.$pag.'&delart='.$art['id']?>" title="excluir"><img src="ico/no.png" alt="excluir" title="excluir" /></a></td>
                  </tr>
<?php
			}
?>
                </table>
<?php
			$url = '?url=posts/posts&pag=';
			if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
				$params = array('%'.$_SESSION['search'].'%');
				$types = 's';
			}else{
				$params = NULL;
				$types = NULL;
			}
			paginator('cuc_posts', "WHERE type='post'".($_SESSION['where'] ?? '')."ORDER BY date DESC", $params, $types, $max, $url, $pag);
		}elseif($pag == 1){
			echo '<span class="ms in">Não foram encontrados artigos!</span>';
		}else header('Location: ?url=posts/posts');
?>
            </div><!-- /bloco list -->
            <span class="ms al" id="window-del">
                <p>Atenção: Você está prestes a excluir um artigo. Deseja continuar?</p>
                <p style="text-align:center;"><a class="btnalt" name="excluir" href="#">SIM</a> <a class="close-del btn">NÃO</a></p>
            </span>
            <div id="mask"></div>
<?php
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>