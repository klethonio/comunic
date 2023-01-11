<?php
/***********************************
FUNÇÃO GET URL
***********************************/
function getUrl(){
	$url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
	$url = explode('/', $url);
	$url[0] = empty($url[0]) ? 'index' : $url[0];
	if(file_exists('tpl/'.$url[0].'.php')){
		require_once('tpl/'.$url[0].'.php');
	}elseif(empty($url[1])){
		require_once('tpl/404.php');
	}elseif(file_exists('tpl/'.$url[0].'/'.$url[1].'.php')){
		require_once('tpl/'.$url[0].'/'.$url[1].'.php');
	}else require_once('tpl/404.php');
}
/***********************************
FUNÇÃO GET THUMB
***********************************/
function getThumb($img, $title, $w, $h, $group = NULL, $dir = NULL, $link = NULL){
	$group 	= ($group ? "[".$group."]" : "");
	$dir 	= ($dir ? $dir : "uploads");
	$selfDir = explode('/',$_SERVER['PHP_SELF']);
	$urlDir = (in_array('admin',$selfDir) ? '../' : '');
	if(file_exists($urlDir.$dir.'/'.$img) && is_file($urlDir.$dir.'/'.$img)){
		if($link == ''){
			echo '<a href="'.BASE.'/'.$dir.'/'.$img.'" rel="shadowbox'.$group.'" title="'.$title.'">
					<img src="'.BASE.'/tim.php?src='.BASE.'/'.$dir.'/'.$img.'&w='.$w.'&h='.$h.'" title="'.$title.'">
				</a>';
		}elseif($link == '#'){
			echo '<img src="'.BASE.'/tim.php?src='.BASE.'/'.$dir.'/'.$img.'&w='.$w.'&h='.$h.'" title="'.$title.'">';
		}else{
			echo '<a href="'.$link.'" title="'.$title.'">
					<img src="'.BASE.'/tim.php?src='.BASE.'/'.$dir.'/'.$img.'&w='.$w.'&h='.$h.'" title="'.$title.'">
				</a>';
		}
	}elseif($link){
		echo '<a href="'.$link.'" title="'.$title.'">
				<img src="'.BASE.'/tim.php?src='.BASE.'/tpl/images/default.jpg&w='.$w.'&h='.$h.'" title="'.$title.'">
			</a>';
	}else{
		echo '<img src="'.BASE.'/tim.php?src='.BASE.'/tpl/images/default.jpg&w='.$w.'&h='.$h.'" title="'.$title.'">';
	}
}
/***********************************
FUNÇÃO GET CAT
***********************************/
function getCat($id, $column = NULL){
	global $pdo;
	$readCategory = read('cuc_categories',"WHERE id=?", array($id), 'i');	
	if($readCategory){
		foreach($readCategory as $cat);
		if($column){
			return $cat[$column];
		}else{
			return $cat;
		}
	}else{
		return 'Erro ao ler categoria';	
	}
}
/***********************************
FUNÇÃO GET AUTOR
***********************************/
function getAut($id, $column = NULL){
	global $pdo;
	$readAuthor = read('cuc_users',"WHERE id=?", array($id), 'i');		
	if($readAuthor){
		foreach($readAuthor as $author);
		if(!$author['avatar']){		
			$gravatar  = 'http://www.gravatar.com/avatar/';
			$gravatar .= md5(strtolower(trim($author['email'])));
			$gravatar .= '?d=mm&s=180';
			$author['avatar'] = $gravatar;
		}else $author['avatar'] = BASE.'/uploads/avatars/'.$author['avatar'];
		if(!$column){
			return $author;	
		}else{
			return $author[$column];
		}
	}else{
		echo 'Erro ao ler autor';
	}
}
/***********************************
FUNÇÃO GET USER
***********************************/
function getUser($user, $maxNivel = NULL){
	if($maxNivel){
		if($readUser = read('cuc_users', 'WHERE id=?', array($user), 'i')){
			foreach($readUser as $user);
			if($user['level'] <= $maxNivel){
				return true;
			}
		}
	}else{
		return true;
	}
}
?>