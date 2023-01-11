<ul class="box">
	<li>
    	<h3>Top 5</h3>
        <ul class="top">
<?php
$num = 0;
if($readTop = read('cuc_posts', "WHERE type='post' AND status='1' ORDER BY views DESC LIMIT 5")){
	foreach($readTop as $top){
		$num++;
?>
        	<li>
            	<a href="<?=BASE.'/artigo/'.$top['url']?>" title="Ver mais sobre <?=$top['title']?>">
                	<span class="num"><?=$num?></span> 
                    <?=$top['title']?>
                </a>
            </li>
<?php
	}
}
?>
        </ul>
    </li>
	<li>
    	<iframe src="//www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/comunicPB&amp;width=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true&amp;appId=209499939111093" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:250px;" allowTransparency="true"></iframe>
    </li>
</ul>