<?php
$catUrl = $url[1];
if($readCat = read('cuc_categories', 'WHERE url=?', array($catUrl), 's')){
	foreach($readCat as $cat);
?>
<title><?=SITENAME.' | '.$cat['name']?></title>
<meta name="title" content="<?=SITENAME.' | '.$cat['name']?><" />
<meta name="description" content="<?=$cat['content']?>" />
<meta name="keywords" content="<?=$cat['tags']?>" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE.'/categoria/'.$cat['url']?>" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="categoria">
    	<h1>Notícias sobre <?=$cat['name']?>:</h1>
<?php
	echo '<ul class="arts">';
	$pag = (($url[2] ?? null) == 'page' && !empty($url[3])) ? $pag = $url[3] : 1;
	$max = 12;
	$start = ($pag-1)*$max;
	if($cat['id_parent']){
		$readPost = read('cuc_posts', "WHERE type='post' AND status='1' AND category=? ORDER BY date DESC LIMIT ?, ?", array($cat['id'], $start, $max), 'iii');
	}else $readPost = read('cuc_posts', "WHERE type='post' AND status='1' AND cat_parent=? ORDER BY date DESC LIMIT ?, ?", array($cat['id'], $start, $max), 'iii');
	if($readPost){
		$i = 0;
		foreach($readPost as $post){
			$i++
?>
        	<li<?php if($i%4==0)echo ' class="last"';?>>
            	<?=getThumb($post['thumb'], $post['tags'], 200, 150, '', '', BASE.'/artigo/'.$post['url'])?>
                <p class="data"><?=date('d/m/Y H:i', strtotime($post['date']))?></p>
                <a title="Ver mais sobre <?=$post['title']?>" href="<?=BASE.'/artigo/'.$post['url']?>" class="link"><p class="titulo"><?=resText($post['title'], 50)?></p></a>
            </li>
<?php
		}
	}elseif($pag == 1){
		echo '<span class="ms in">Não foram encontrados artigos nesta categoria!</span>';
	}else header('Location: '.BASE.'/categoria/'.$cat['url']);
	echo '</ul>';
	$url = BASE.'/categoria/'.$cat['url'].'/page/';
	if($cat['id_parent']){
		paginator('cuc_posts', "WHERE type='post' AND status='1' AND category=? ORDER BY date DESC", array($cat['id']), 'id', $max, $url, $pag);
	}else paginator('cuc_posts', "WHERE type='post' AND status='1' AND cat_parent=? ORDER BY date DESC", array($cat['id']), 'i', $max, $url, $pag, '870px');
	
?>
</div><!-- /categoria -->
</div><!-- //content -->
<?php
}else header('Location: '.BASE.'/404');
?>