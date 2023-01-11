<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
?>
            <div class="bloco form" style="display:block">
<?php
		if(!empty($_POST['sendForm'])){
			$f[0] = $_POST['region1'];
			$f[1] = $_POST['region2'];
			$f[2] = $_POST['region3'];
			$f[3] = $_POST['region4'];
			
			if(count(array_unique($f)) != count($f) ){
				echo '<span class="ms no">Uma categoria foi selecionada em mais de uma região!</span>';
			}else{
				for($i = 0; $i < 4; $i++){
					update('cuc_regions', array('category' => $f[$i]), 'WHERE region=?', array($i), 'ii');
				}
				echo '<span class="ms ok">Áreas atualizadas com sucesso!</span>';
			}
		}
?>
            	<div class="titulo">Editar regiões de Categorias:</div>
                <div id="region-site">
                <div id="slide">SLIDE</div>
                <div id="home1">AREA 1</div>
                <div id="home2">AREA 2</div>
                <div id="home3">AREA 3</div>
                <div id="home4">AREA 4</div>
                </div>
                <div id="regions">
                    <form name="formRegion" action="" method="post">
                        <label class="line">
                            <span class="data">Area 1:</span>
                            <select name="region1">
<?php
		$regions = read('cuc_regions', 'ORDER BY region ASC LIMIT 0, 4');
		if($readParentCat = read('cuc_categories', 'WHERE id_parent IS NULL')){
			foreach($readParentCat as $parentCat){
				echo '<option';
				if($regions[0]['category'] == $parentCat['id']) echo ' selected';
				echo ' value="'.$parentCat['id'].'">'.$parentCat['name'].'</option>';
			}
		}
?>
                            </select>
                        </label>
                        <label class="line">
                            <span class="data">Area 2:</span>
                            <select name="region2">
<?php
		if($readParentCat = read('cuc_categories', 'WHERE id_parent IS NULL')){
			foreach($readParentCat as $parentCat){
				echo '<option';
				if($regions[1]['category'] == $parentCat['id']) echo ' selected';
				echo ' value="'.$parentCat['id'].'">'.$parentCat['name'].'</option>';
			}
		}
?>
                            </select>
                        </label>
                        <label class="line">
                            <span class="data">Area 3:</span>
                            <select name="region3">
<?php
		if($readParentCat = read('cuc_categories', 'WHERE id_parent IS NULL')){
			foreach($readParentCat as $parentCat){
				echo '<option';
				if($regions[2]['category'] == $parentCat['id']) echo ' selected';
				echo ' value="'.$parentCat['id'].'">'.$parentCat['name'].'</option>';
			}
		}
?>
                            </select>
                        </label>
                        <label class="line">
                            <span class="data">Area 4:</span>
                            <select name="region4">
<?php
		if($readParentCat = read('cuc_categories', 'WHERE id_parent IS NULL')){
			foreach($readParentCat as $parentCat){
				echo '<option';
				if($regions[3]['category'] == $parentCat['id']) echo ' selected';
				echo ' value="'.$parentCat['id'].'">'.$parentCat['name'].'</option>';
			}
		}
?>
                            </select>
                        </label>
                        <label class="line">
                        	<span class="obs">Obs.: Selecione categorias diferentes!</span>
                        </label>
                    	<input type="submit" value="Atualizar" name="sendForm" class="btn" />
                    </form>
                </div>
			</div>
<?php
	}else echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
}else header('Location: ../index2.php');
?>