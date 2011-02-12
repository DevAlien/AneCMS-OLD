<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Admintasia v2</title>
	<!--<script type="text/javascript" src="./skins/admintasia/js/jquery-1.4.2.js"></script>-->
	<link rel="stylesheet" type="text/css" href="http://localhost/test/ANECMS/system/pages/bootstrap.css.php?system/js/jquery.jgrowl.css|system/js/default.css|system/js/markitup/skins/markitup/style.css|system/js/markitup/sets/default/style.css|system/js/markitup/sets/css/style.css" media="screen"/> <script type="text/javascript" src="http://localhost/test/ANECMS/system/pages/bootstrap.js.php?system/js/jquery-1.3.2.min.js|system/js/jquery.jgrowl_minimized.js|system/js/admin.js|system/js/php_file_tree_jquery.js|system/js/markitup/jquery.markitup.pack.js|system/js/markitup/sets/default/set.js|system/js/markitup/sets/css/set.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.core.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.widget.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.mouse.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/superfish.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/live_search.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/tooltip.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/cookie.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.sortable.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.draggable.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.resizable.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.position.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.button.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.dialog.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/custom.js"></script>
	<script type="text/javascript" src="./skins/admintasia/js/ui/ui.accordion.js"></script>
<script type="text/javascript">
$(function() {
  $("#accordion").accordion({
  });
});
</script>

	<link href="./skins/admintasia/css/ui/ui.base.css" rel="stylesheet" media="all" />

	<link href="./skins/admintasia/css/themes/blueberry/ui.css" rel="stylesheet" title="style" media="all" />

	<!--[if IE 6]>
	<link href="css/ie6.css" rel="stylesheet" media="all" />
	
	<script src="js/pngfix.js"></script>
	<script>
	  /* Fix IE6 Transparent PNG */
	  DD_belatedPNG.fix('.logo, .other ul#dashboard-buttons li a');

	</script>
	<![endif]-->
	<!--[if IE 7]>
	<link href="css/ie7.css" rel="stylesheet" media="all" />
	<![endif]-->
</head>
<body id="sidebar-left">
		
	<div id="page_wrapper">
		<div id="page-header">
			<div id="page-header-wrapper">
				<div id="top">
					<a href="dashboard.php" class="logo" title="AneCMS">AneCMS</a>
					<div class="welcome">
						<span class="note">Welcome, <a href="#" title="Welcome, <?php echo $user->getValues('username');?>"><?php echo $user->getValues('username');?></a></span>
						<!--<a class="btn ui-state-default ui-corner-all" href="#">
							<span class="ui-icon ui-icon-wrench"></span>
							Settings
						</a>
						<a class="btn ui-state-default ui-corner-all" href="#">
							<span class="ui-icon ui-icon-person"></span>
							My account
						</a>-->
						<a class="btn ui-state-default ui-corner-all" href="../index.php">
							<span class="ui-icon ui-icon-power"></span>
							<?php echo $lang['cms'];?>
						</a>						
					</div>
				</div>
				<ul id="navigation">
				<?php $counter_top_menu=0; foreach($var['top_menu'] as $key => $top_menu){ $counter_top_menu++; ?>
                <li><a href="<?php echo $qgeneral['url_base'];?><?php echo $top_menu['link'];?>"><?php echo $top_menu['name'];?></a></li>
                
            <?php } ?>
				<!--<li><a href="index.php"><?php echo $lang['dashboard'];?></a></li>
        	<li><a href="?p=cfg"><?php echo $lang['configuration'];?></a></li>
        	<li><a href="?p=tpl"><?php echo $lang['design'];?></a></li>
        	<li><a href="?p=mod"><?php echo $lang['modules'];?></a></li>
					</ul>-->
				<!--<div id="search-bar">
					<form method="post" action="http://www.google.com/">
						<input type="text" name="q" value="live search demo" />
					</form>
				</div>-->
			</div>
		</div>
		<div id="sub-nav"><div class="page-title">
		
	<h1><?php echo $lang['templates'];?></h1>
	<span><a href="?p=tpl" title="Layout Options"><?php echo $lang['templates'];?></a> > <a href="?p=cfg&m=reposerver" title=""><?php echo $lang['insert'];?></a></span>

			
		</div>
		</div>
		<div id="page-layout">
			<div id="page-content">
				<div id="page-content-wrapper">
					

<div class="inner-page-title">
						<h3><?php echo $lang['templates'];?></h3>	
<span><?php echo $lang['templatesdesc'];?></span>						
					</div>
<div class="content-box">
<div class="hastable" id="table">
 </div></div>

					<div class="clearfix"></div>
					<!--SIDEBAR-->
							<div id="sidebar">
			<div class="sidebar-content">
			
<?php echo php_file_tree('../skins/',"javascript:loadTplToModify('[link]','[ext]','[fname]','[chmod]');"); ?>

			</div>
		</div>
		<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	<div class="clear"></div>
	<div id="footer">
		<a href="http://anecms.com" title="Home">AneCMS</a>
	</div>
<!-- Do not remove the copyright notice unless you have purchased a Commercial License from admintasia.com -->
	<div id="copyright">
		Design Powered by <a href="http://www.admintasia.com" title="Powerful admin UI template">Admintasia.com</a>
	</div>
<!-- Do not remove the copyright notice unless you have purchased a Commercial License from admintasia.com -->
</div>

                    <script type="text/javascript">
                     $(function()
			{
		    });</script>
</body>
</html>