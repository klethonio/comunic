<title><?=SITENAME?> - Comunidade Universitária de Coremas</title>
<meta name="title" content="<?=SITENAME?> - Comunidade Universitária de Coremas" />
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

<div class="home">
<?php
if($readSlide = read('cuc_posts as a', "WHERE a.type='post' AND a.status='1' AND a.id=(SELECT max(id) FROM cuc_posts WHERE cat_parent = a.cat_parent)")){
?>
	<div class="slide">
    	<ul>
<?php
	foreach($readSlide as $slide){
		$subCat = getCat($slide['category']);
?>
        	<li>
                <?=getThumb($slide['thumb'], $slide['tags'], 865, 254, '', '', '#')?>
                <div class="info">
                	<p class="titulo"><a href="<?=BASE.'/artigo/'.$slide['url']?>" title="Ver mais de <?=$slide['title']?>"><?=getCat($subCat['id_parent'], 'name').' - '.$slide['title']?></a></p>
               		<p class="resumo"><a href="<?=BASE.'/artigo/'.$slide['url']?>" title="Ver mais de <?=$slide['title']?>"><?=resText($slide['content'], 200)?></a></p>
               	</div><!-- /info -->
            </li>
<?php
	}
	
?>
		</ul>
		<div class="slidenav"></div><!-- /slide nav-->
	</div><!-- /slide -->
<?php
}
?>
    
    <ul class="entretenimeto">
<?php
	$region = read('cuc_regions');
if($readBlock = read('cuc_posts as a', "WHERE type='post' AND status = '1' AND cat_parent=? ORDER BY date DESC LIMIT 1, 5", array($region[0]['category']), 'i')){
	$i=0;
	foreach($readBlock as $block){
?>
    	<li<?php if($i==4)echo ' class="last"';?>>
        	<?=getThumb($block['thumb'], $block['tags'], 168, 234, '', '', '#')?>
            <div class="info">
            	<p class="data"><?=date('d/m/Y H:i', strtotime($block['date']))?></p>
           		<p class="titulo"><a href="<?=BASE.'/artigo/'.$block['url']?>"><?=$block['title']?></a></p>
           </div><!-- /info -->
        </li>
<?php
		$i++;
	}
}
?>
    </ul><!-- /entretenimento -->
    
    <div class="bl-games-tec">
    	<div class="games">
<?php
      echo '<h2>'.getCat($region[1]['category'], 'name').'</h2>';
if($readBlock = read('cuc_posts', "WHERE type='post' AND status = 1 AND cat_parent=? ORDER BY date DESC LIMIT 1, 3", array($region[1]['category']), 'i')){
      echo '<ul class="ulgames">';
	foreach($readBlock as $block){
?>
            		<li class="gli">
                    	<?=getThumb($block['thumb'], $block['tags'], 180, 100, '', '', '#')?>
                    	<p class="titulo"><a href="<?=BASE.'/artigo/'.$block['url']?>" class="trans"><?=$block['title']?></a></p>
                        <p class="data"><?=date('d/m/Y H:i', strtotime($block['date']))?></p>
                        <span class="link"><a href="<?=BASE.'/artigo/'.$block['url']?>" class="radius bsshadow">continue lendo...</a></span>
                    </li>
<?php
	}
}
?>
            </ul><!-- /ulgames -->
        </div><!-- /games -->
        
        <div class="tec">
<?php
      echo '<h2>'.getCat($region[2]['category'], 'name').'</h2>';
if($readBlock = read('cuc_posts', "WHERE type='post' AND status = 1 AND cat_parent=? ORDER BY date DESC LIMIT 1, 3", array($region[2]['category']), 'i')){
      echo '<ul class="ultec">';
	$i=0;
	foreach($readBlock as $block){
?>
                <li class="bsshadow<?php if($i==2)echo ' last';?>">
                	<?=getThumb($block['thumb'], $block['tags'], 133, 237, '', '', '#')?>
                    <span class="info">
                    	<p class="titulo"><a href="<?=BASE.'/artigo/'.$block['url']?>"><?=$block['title']?></a></p>
                    	<p class="data"><?=date('d/m/Y H:i', strtotime($block['date']))?></p>
                    </span>
                </li>
<?php
		$i++;
	}
}
?>
            </ul>
            
            <ul class="ultecover">
<?php
if($readBlock = read('cuc_posts', "WHERE type='post' AND status = 1 AND cat_parent=? ORDER BY date DESC LIMIT 4, 2", array($region[2]['category']), 'i')){
      echo '<ul class="ulgames">';
	foreach($readBlock as $block){
?>
            	<li class="bsshadow">
                	<span class="data"><?=date('d/m', strtotime($block['date']))?></span>
                    <span class="titulo"><a href="<?=BASE.'/artigo/'.$block['url']?>"><?=$block['title']?></a></span>
                </li>
<?php
	}
}
?>
            </ul>
        </div><!-- /tec -->
    </div><!-- /bloco games + tecnologia -->
    
    <div class="internet">
<?php
   echo '<h2>'.getCat($region[3]['category'], 'name').'</h2>';
if($readBlock = read('cuc_posts', "WHERE type='post' AND status='1' AND cat_parent=? ORDER BY date DESC LIMIT 0, 4", array($region[3]['category']), 'i')){
      echo '<ul class="inter">';
	$i=0;
	foreach($readBlock as $block){
?>
        	<li class="bsshadow radius<?php if($i==3)echo ' last';?>">
            	<?=getThumb($block['thumb'], $block['tags'], 200, 150, '', '', BASE.'/artigo/'.$block['url'])?>
                <p class="data"><?=date('d/m/Y H:i', strtotime($block['date']))?></p>
                <p class="titulo"><?=$block['title']?></p>
            </li>
<?php
		$i++;
	}
}
?>
        </ul>
    </div>
    
</div><!-- /home -->
</div><!-- //content -->