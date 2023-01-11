<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
?>
            <div class="bloco cat" style="display:block">
            	<div class="titulo">Categorias: <a href="?url=posts/category-create" title="Criar nova categoria" class="btn" style="float:right;">Criar Categoria</a></div>   
<?php
		if(!empty($_SESSION['return'])){
			echo $_SESSION['return'];
			unset($_SESSION['return']);
		}
		$pag = $_GET['pag'] ?? 1;
		$max = 3;
		$start = ($pag-1)*$max;
		if(!empty($_GET['delcat'])){
			$idDel = ($_GET['delcat']);
			if(!read('cuc_categories', 'WHERE id_parent=?', array($idDel), 'i')){
				delete('cuc_categories', 'WHERE id=?', array($idDel), 'i');
				$_SESSION['return'] = '<span class="ms ok">Categoria removida com sucesso!</span>';
				header('Location: ?url=posts/categories&pag='.$pag);
			}else{
				echo '<span class="ms al">Uma categoria não pode ser excluida quando está possui subcategorias!</span>';
			}
		}
		if(!empty($_GET['delsub'])){
			$idDel = ($_GET['delsub']);
			delete('cuc_categories', 'WHERE id=?', array($idDel), 'i');
			$_SESSION['return'] = '<span class="ms ok">Categoria removida com sucesso!</span>';
			header('Location: ?url=posts/categories&pag='.$pag);
		}
		
		if($readCat = read('cuc_categories', 'WHERE id_parent IS NULL LIMIT ?, ?', array($start, $max), 'ii')){
?>                   
                <table width="560" border="0" class="tbdados" style="float:left;" cellspacing="0" cellpadding="0">
                  <tr class="ses">
                    <td>categoria:</td>
                    <td>resumo:</td>
                    <td align="center">tags:</td>
                    <td align="center">criada:</td>
                    <td align="center" colspan="3">ações:</td>
                  </tr>
<?php
			foreach($readCat as $cat){
				$catTags = $cat['tags'] ? 'ok.png' : 'no.png';
?>
                  <tr>
                    <td><?=$cat['name']?></td>
                    <td><?=resText($cat['content'], 35)?></td>
                    <td align="center"><img src="ico/<?=$catTags?>" alt="<?=$cat['tags']?>" title="<?=$cat['tags']?>" /></td>
                    <td align="center"><?=date('d/m/Y H:i', strtotime($cat['date']))?></td>
                    <td align="center"><a href="?url=posts/subcategory-create&catid=<?=$cat['id']?>" title="criar sub-categoria"><img src="ico/new.png" alt="criar" title="criar sub-categoria" /></a></td>
                    <td align="center"><a href="?url=posts/category-edit&catid=<?=$cat['id']?>" title="editar categoria <?=$cat['name']?>"><img src="ico/edit.png" alt="editar" title="editar categoria <?=$cat['name']?>" /></a></td>
                    <td align="center"><a href="#window-del" rel="?url=posts/categories&pag=<?=$pag?>&delcat=<?=$cat['id']?>" title="excluir"><img src="ico/no.png" alt="excluir" title="excluir categoria <?=$cat['name']?>" /></a></td>
                  </tr>
<?php
				if($readSubCat = read('cuc_categories', 'WHERE id_parent=?', array($cat['id']), 'i')){
					foreach($readSubCat as $subCat){
						$subCatTags = $subCat['tags'] ? 'ok.png' : 'no.png';
?>
                  <tr class="subcat">
                    <td>&raquo;&raquo; <?=$subCat['name']?></td>
                    <td><?=resText($subCat['content'], 40)?></td>
                    <td align="center"><img src="ico/<?=$subCatTags?>" alt="<?=$subCat['tags']?>" title="<?=$subCat['tags']?>" /></td>
                    <td align="center"><?=date('d/m/Y H:i', strtotime($subCat['date']))?></td>
                    <td align="center" colspan="2"><a href="?url=posts/category-edit&catid=<?=$subCat['id']?>" title="editar categoria <?=$subCat['name']?>"><img src="ico/edit.png" alt="editar" title="editar categoria <?=$subCat['name']?>" /></a></td>
                    <td align="center"><a href="#window-del" rel="?url=posts/categories&pag=<?=$pag?>&delsub=<?=$subCat['id']?>" title="excluir"><img src="ico/no.png" alt="excluir" title="excluir categoria <?=$subCat['name']?>" /></a></td>
                  </tr>
<?php
					}
				}
			}
        	echo '</table>';
			$url = '?url=posts/categories&pag=';
			paginator('cuc_categories', 'WHERE id_parent IS NULL', "", "", $max, $url, $pag);
?>
         	</div><!-- /bloco cat -->
            <span class="ms al" id="window-del">
                <p>Atenção: Você está prestes a excluir uma categoria. Deseja continuar?</p>
                <p style="text-align:center;"><a class="btnalt" name="excluir" href="#">SIM</a> <a class="close-del btn">NÃO</a></p>
            </span>
            <div id="mask"></div>
<?php
		}elseif($pag == 1){
			echo '<span class="ms in">Não existe categorias!</span>';
		}else header('Location: ?url=posts/categories');
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>