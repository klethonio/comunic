<header id="header">
	<div class="logo-img">
    	<img src="<?=BASE?>/tpl/images/logo.png"/>
    </div>
    <div class="logo">
        <a href="<?=BASE?>" title="<?=SITENAME?> - Comunidade Universitária de Coremas">
            <h1 class="title">Comunic Notícias</h1>
        </a>
    </div><!-- /header-logo -->
    
    <div class="search">
<?php
$searching = filter_input(INPUT_POST, 'search', FILTER_DEFAULT);
if($searching){
	$search = $_POST['words'];
	$search = setUrl($search);
	header('Location: '.BASE.'/pesquisa/'.$search);
}
?>
    	<form name="formSearch" method="post">
        	<label><input type="text" name="words" autocomplete="off" value="" /></label>
            <input type="submit" class="btn" name="search" value="Buscar!" />
        </form>
    </div><!-- /headr-search -->
    
    <ul class="hnav">
    	<li><a title="<?=SITENAME?> | Home" href="<?=BASE?>">Home</a></li>
<?php
if($readCat = read('cuc_categories', 'WHERE id_parent IS NULL')){
	foreach($readCat as $cat){
		echo '<li><a title="'.SITENAME.' | '.$cat['name'].'" href="'.BASE.'/categoria/'.$cat['url'].'">'.$cat['name'].'</a>';
		if($readSubCat = read('cuc_categories', 'WHERE id_parent=?', array($cat['id']), 'i')){
			echo '<ul class="sub">';
			foreach($readSubCat as $subCat){
				echo '<li><a title="'.SITENAME.' | '.$subCat['name'].'" href="'.BASE.'/categoria/'.$subCat['url'].'">'.$subCat['name'].'</a></li>';
			}
			echo '</ul>';
		}
		echo '</li>';
	}
}
if(empty($_SESSION['adUser'])){
?>
        <li><a title="<?=SITENAME?> | Cadastre-se" href="<?=BASE?>/pagina/cadastro">Cadastrar</a></li>
        <li><a title="<?=SITENAME?> | Logar-se" href="<?=BASE?>/pagina/login">Entrar</a></li>
<?php
}else{
?>
        <li><a title="<?=SITENAME?> | Meu perfil" href="<?=BASE?>/pagina/perfil">Meu perfil</a></li>
        <li><a title="<?=SITENAME?> | Deslogar" href="<?=BASE?>/pagina/logout">Deslogar</a></li>
<?php
}
?>
        <li><a title="<?=SITENAME?> | Contato" href="<?=BASE?>/pagina/contato">Contato</a></li>
    </ul><!-- /hnav -->
    
</header><!-- /header -->