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
    </div><!-- // content -->
    
    <div class="sidebar">
    	<?php setArq('tpl/sidebar'); ?>
    </div><!-- //sidebar -->
   </div><!-- /single -->
</div><!-- //content -->
<?php
	}else header('Location: '.BASE.'/404');
}else header('Location: '.BASE);
?>