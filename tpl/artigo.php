<?php
if(function_exists('read') && $url[1]){
	if($readPost = read('cuc_posts', 'WHERE url=?', array($url[1]), 's')){
		foreach($readPost as $post);
		setViews($post['id']);
?>
<title><?=$post['title']?> - <?=SITENAME?></title>
<meta name="title" content="<?=$post['title']?> - <?=SITENAME?>" />
<meta name="description" content="<?=resText($post['content'], 100)?>" />
<meta name="keywords" content="<?=$post['tags']?>" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE.'/artigo/'.$post['url']?>" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="single">
	<h1 class="pgtitulo"><?=$post['title']?></h1>
      
    <div class="content">
    	<span style="float:right;padding:0 0 5px 8px;" class="thumb"><?=getThumb($post['thumb'], $post['tags'], 200, 200)?></span>
		<?=$post['content']?>
      
<?php
		if($readGallery = read('cuc_gallery', 'WHERE post_id=?', array($post['id']), 'i')){
			echo '<ul class="gallery">';
			$imgNum = 0;
			foreach($readGallery as $gallery){
				$imgNum++;
?>
            	<li><?=getThumb($gallery['img'], $post['title'].' - '.$imgNum, 96, 60, $post['id'], '', '')?></li>
<?php
			}
			echo '</ul><!-- //gallery -->';
		}
?>
        <div class="metadata">
<?php
		$author = getAut($post['author']);
?>
        	<img src="<?=BASE.'/tim.php?src='.$author['avatar']?>&w=50&h=50" title="<?=$author['name']?>">
            <span class="autor">Por: <?=$author['name']?></span> 
            <span class="data">dia: <?=date('d/m/Y H:i', strtotime($post['date']))?></span>
            <span class="cat">em: <a href="<?=BASE.'/categoria/'.getCat($post['category'], 'url')?>"><?=getCat($post['category'], 'name')?></a></span>
            <span class="tags"><?=$post['tags']?></span>
            <span class="views"><?=$post['views']?> Visitas </span>
            <span style="float:right;"><?php if($post['update_date']) echo 'Atualizado em: '.date('d/m/Y H:i', strtotime($post['update_date']))?></span>
        </div><!-- /metadata -->
    
    </div><!-- // content -->
    
    <div class="sidebar">
    	<?php setArq('tpl/sidebar'); ?>
    </div><!-- //sidebar -->
   </div><!-- /single -->
</div><!-- //content -->
<?php
	}elseif($sainda = searchUrl($url[1])){
		header('Location: '.BASE.'/artigo/'.$sainda);
	}else header('Location: '.BASE.'/404');
}else header('Location: '.BASE);
?>