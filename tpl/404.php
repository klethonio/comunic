<title>404 | Opssss não encontrado! | <?=SITENAME?></title>
<meta name="title" content="404 | Opssss não encontrado! <?=SITENAME?>" />
<meta name="description" content="<?=SITEDESC?>" />
<meta name="keywords" content="<?=SITETAGS?>" />
<meta name="author" content="Klethônio Ferreira" />
<meta name="url" content="<?=BASE?>" /> 
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>

<div id="site">

<?php setArq('tpl/header'); ?>

<div id="content">

	<div class="notfound">
    
    	<h1 class="pgtitulo">Opppppssss, não conseguimos encontrar o que você procura!</h1>
        <p class="pgtext">A url que você informou não retornou nenhum resultado. Talvez a página tenha sido removida ou o artigo não exista mais. Você pode tentar navegar pelo nosso menu ou pesquisar pelo sistema ou ainda voltar á 
        <a class="pglink" href="<?=BASE?>" title="voltar ao início!">Home</a>.</p>
         <p class="pgtext"><strong>Você pode conferir nossas últimas atualizações logo abaixo:</strong></p>
         
         

<?php
if($readCat = read('cuc_regions', 'LIMIT 4, 4')){
	foreach($readCat as $cat){
		switch($cat['region']){
			case 4: $region = 'entre'; break;
			case 5: $region = 'games'; break;
			case 6: $region = 'tecno'; break;
			case 7: $region = 'entre'; break;
		}
		$i=0;
?>
    <div class="bloco <?=$region?>">
    	<h2><?=getCat($cat['category'], 'name')?></h2>
        <ul class="inter">
<?php
		if($readPost = read('cuc_posts', "WHERE type='post' AND status='1' AND cat_parent=? ORDER BY date DESC LIMIT 4", array($cat['category']), 'i')){
			foreach($readPost as $post){
				$i++;
?>
        	<li class="bsshadow radius<?php if($i==4)echo ' last';?>">
            	<?=getThumb($post['thumb'], $post['tags'], 200, 150, '', '', BASE.'/artigo/'.$post['url'])?>
                <p class="data"><?=date('d/m/Y H:i', strtotime($post['date']))?></p>
                <p class="titulo"><?=resText($post['title'], 60)?></p>
            </li>
<?php
			}
		}
?>
        </ul>
    </div>
<?php		
	}
}
?>
    </div><!-- //notfound -->

</div><!-- //content -->