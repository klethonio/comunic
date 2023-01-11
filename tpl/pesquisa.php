<?php
$searchWords = $url[1];
$searchWords = str_replace('-', ' ', $searchWords);
?>
<title>Buscas relacionadas a: <?=$searchWords.' | '.SITENAME?></title>
<meta name="title" content="Buscas relacionadas a: <?=$searchWords.' | '.SITENAME?>" />
<meta name="description" content="<?=SITENAME?> | Pesquisa relacionada à <?=$searchWords?>" />
<meta name="keywords" content="<?=str_replace(' ', ', ', $searchWords)?>" />
<meta name="author" content="Klethônio Ferreira" />   
<meta name="url" content="<?=BASE.'/pesquisa/'.str_replace(' ', '-', $searchWords)?>" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

<div class="single">
	<h1 class="pgtitulo">Buscas relacionadas a: "<?=$searchWords?>"</h1>
    <div class="content">
<?php

$pag = (($url[2] ?? null) == 'page' && $url[3]) ? $pag = $url[3] : 1;
$max = 7;
$start = ($pag-1)*$max;
if($readSearch = read('cuc_posts', "WHERE type='post' AND status='1' AND (title LIKE ? OR content LIKE ? OR tags LIKE ?) LIMIT ?, ?", array('%'.$searchWords.'%', '%'.$searchWords.'%', '%'.$searchWords.'%', $start, $max), 'sssii')){
	$readTotal = read('cuc_posts', "WHERE type='post' AND status='1' AND (title LIKE ? OR content LIKE ? OR tags LIKE ?)", array('%'.$searchWords.'%', '%'.$searchWords.'%', '%'.$searchWords.'%'), 'sss');
	echo '<p style="margin:0;">Sua pesquisa retornou <strong><?=count($readTotal)?></strong> resultados!</p>';
	echo '<ul class="searchlist">';

	foreach($readSearch as $search){
?>
            	<li>
                	<?=getThumb($search['thumb'], $search['tags'], 110, 60, '', '', BASE.'/artigo/'.$search['url'])?>
                    <a title="Ver mais sobre <?=$search['title']?>" href="<?=BASE.'/artigo/'.$search['url']?>"><?=$search['title']?></a>
                </li>
<?php
	}
}elseif($pag == 1){
		echo '<h2>Desculpe, sua pesquisa não retornou resultados.</h2><h4>Você pode usar outros termos ou navegar no nosso menu!</h4><p>Talvez você queira resumir sua pesquisa, muitas palavras, as vezes, não retornam resultados!</p>';
}else header('Location: '.BASE.'/pesquisa/'.str_replace(' ', '-', $searchWords));
	echo '</ul><!-- /searchlist -->';
	$url = BASE.'/pesquisa/'.str_replace(' ', '-', $searchWords).'/page/';
paginator('cuc_posts', "WHERE type='post' AND status='1' AND (title LIKE ? OR content LIKE ? OR tags LIKE ?)", array('%'.$searchWords.'%', '%'.$searchWords.'%', '%'.$searchWords.'%'), 'sss', $max, $url, $pag, '540px');
?>
    </div><!-- // content -->
    
    <div class="sidebar">
    	<?php setArq('tpl/sidebar'); ?>
    </div><!-- //sidebar -->
   </div><!-- /single -->
</div><!-- //content -->