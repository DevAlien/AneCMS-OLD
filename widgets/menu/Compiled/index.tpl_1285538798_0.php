<li class="widget"><div>
<h2 name="menu">Menu</h2>
			<ul class="sidemenu">
<?php $counter_sidemenu=0; foreach($var['sidemenu'] as $key => $sidemenu){ $counter_sidemenu++; ?>
<li><a href="<?php echo $qgeneral['url_base'];?><?php echo $sidemenu['link'];?>"><?php echo $sidemenu['name'];?></a></li>
<?php } ?>

			</ul>
</div></li>