<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 2)){
		$artId = $_GET['artid'];
		if($readArt = read('cuc_posts', 'WHERE id=?', array($artId), 'i')){
			foreach($readArt as $art);
		}else header('Location: ?url=posts/posts');
		
?>
			<div class="bloco form" style="display:block">
                <div class="titulo">Postar fotos em <span style="color: #900;"><?=$art['title']?></span>:</div>
				<div style="clear: both;"></div>
                <form action="<?=BASE?>/admin/posts/_gallery_post.php" method="post">
                    <label>
						<input id="galleryFile" name="galleryFile" type="file" accept=".jpg, .png, image/jpeg, image/png" multiple>
                    </label>
					<button type="button" class="btn upload" onclick="$('#galleryFile').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click(); return false;">Enviar Imagens</button>
                </form>
<?php
		if(!empty($_GET['artid']) && !empty($_GET['delid'])){
			$idImg = $_GET['delid'];
			if($img = read('cuc_gallery', 'WHERE id=?',  array($idImg), 'i')){
				$img = $img[0]['img'];
				$pasta = '../uploads/';
				if(file_exists($pasta.$img) && is_file($pasta.$img)){
					unlink($pasta.$img);
					delete('cuc_gallery', 'WHERE id=?', array($idImg), 'i');
				}
			}
		}
		echo '<ul rel="'.$artId.'" class="gblist">';
		if($readGallery = read('cuc_gallery', 'WHERE post_id=?', array($artId), 'i')){
			$i = 0;
			foreach($readGallery as $gallery){
				$i++;
?>
                	<li<?php if($i%6==0){echo ' class="last"';}?>>
                    	<img src="../tim.php?src=<?=BASE.'/uploads/'.$gallery['img']?>&w=85&h=65" width="85" height="65" />
                        <div class="action">
                        	<a href="<?=BASE.'/uploads/'.$gallery['img']?>" rel="shadowbox" title="Imagem de: <?=$art['title']?>"><img src="ico/view.png" title="Imagem de: <?=$art['title']?>" alt="Imagem de: <?=$art['title']?>" /></a>
                            <a href="?url=posts/gallery&artid=<?=$art['id']?>&delid=<?=$gallery['id']?>" title="Exluir imagem <?=$i?>"><img src="ico/no.png" title="Exluir imagem <?=$i?>" alt="Exluir imagem <?=$i?>" /></a>
                        </div><!-- /action -->
                    </li>
<?php
			}
		}
?>
                </ul>
            </div><!-- /bloco form -->
<?php
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>