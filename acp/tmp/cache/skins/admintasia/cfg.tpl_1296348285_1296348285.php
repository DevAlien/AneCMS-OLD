<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Admintasia v2</title>
	<!--<script type="text/javascript" src="./skins/admintasia/js/jquery-1.4.2.js"></script>-->
	<link rel="stylesheet" type="text/css" href="http://localhost/test/ANECMS/system/pages/bootstrap.css.php?system/js/jquery.jgrowl.css" media="screen"/> <script type="text/javascript" src="http://localhost/test/ANECMS/system/pages/bootstrap.js.php?system/js/jquery-1.3.2.min.js|system/js/jquery.jgrowl_minimized.js"></script>
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
		
	<h1><?php echo $lang['configuration'];?></h1>
	<span><a href="?=cfg" title="Layout Options"><?php echo $lang['configuration'];?></a></span>

			
		</div>
		</div>
		<div id="page-layout">
			<div id="page-content">
				<div id="page-content-wrapper">
					
<div class="hastable">
<div class="inner-page-title">
						<h3><?php echo $lang['cfg_overview'];?></h3>
						<?php $counter_cfg=0; foreach($var['cfg'] as $key => $cfg){ $counter_cfg++; ?>
						<span><?php echo $lang['cfg_cms'];?><?php if($cfg['status'] == 1){ ?><font color="green"> <?php echo $lang['open'];?></font><?php } else{ ?><font color="red"> <?php echo $lang['close'];?></font><?php } ?></span>
					</div>
					
					
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<td><?php echo $lang['description'];?></td>
								<td><?php echo $lang['value'];?></td>
							</tr>
						</thead>
						<tbody>
							<tr>
                                <td><?php echo $lang['site_title'];?></td>
                                <td><?php echo $cfg['title'];?></td>
                            </tr>
							<tr class="alt">
                                <td><?php echo $lang['site_desc'];?></td>
                                <td><?php echo $cfg['descr'];?></td>
                            </tr>
							<tr>
                                <td><?php echo $lang['lang_pred'];?></td>
                                <td><?php echo $cfg['language'];?></td>
                            </tr>
							<tr class="alt">
                                <td><?php echo $lang['def_mod'];?></td>
                                <td><?php echo $cfg['default_module'];?></td>
                            </tr>
							<tr>
                                <td><?php echo $lang['url_base'];?></td>
                                <td><?php echo $cfg['url_base'];?></td>
                            </tr>
						</tbody>
					</table>

				</div>
<?php } ?>
</div>

					<div class="clearfix"></div>
					<!--SIDEBAR-->
							<div id="sidebar">
			<div class="sidebar-content">
			
				<a id="close_sidebar" class="btn ui-state-default full-link ui-corner-all" href="#drill">
					<span class="ui-icon ui-icon-circle-arrow-e"></span>
					Close Sidebar
				</a>
				<a id="open_sidebar" class="btn tooltip ui-state-default full-link icon-only ui-corner-all" title="Open Sidebar" href="#"><span class="ui-icon ui-icon-circle-arrow-w"></span></a>
				<div class="hide_sidebar">
				  
					<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
						<div class="portlet-header ui-widget-header">Dash Menu<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
						<div class="portlet-content">
							<ul id="style-switcher" class="side-menu">
								<?php $counter_sidenav=0; foreach($var['sidenav'] as $key => $sidenav){ $counter_sidenav++; ?>
                                                <li><a href="<?php echo $sidenav['link'];?>"><?php echo $lang[ $sidenav['name'] ];?></a></li>
	    <?php } ?>
							</ul>
						</div>
					</div>
					<?php if($var['typepage'] ==  '103'){ ?>
        <div class="box ui-widget ui-widget-content ui-corner-all">
            <h3>Modules Menu</h3>
            <div class="content">
            <div id="accordion">
              <?php $counter_sidenavmodules=0; foreach($var['sidenavmodules'] as $key => $sidenavmodules){ $counter_sidenavmodules++; ?>
                <?php if($sidenavmodules['aid'] != $var['countm']){ ?>
                <?php if($var['countm'] != -1){ ?>
                </ul>
                </div>
                <?php } ?>
                  <h3><a href="#"><?php echo $sidenavmodules['aname'];?></a></h3>
                  <div>
                  <ul class="side-menu">
                <li>
                  <a href="<?php echo $sidenavmodules['link'];?>" title="<?php echo $lang[ $sidenavmodules['name'] ];?>"><?php echo $lang[ $sidenavmodules['name'] ];?></a>
                </li>
                <?php if($var['countm'] = $sidenavmodules['aid']){ ?><?php } ?>
                <?php } else if($sidenavmodules['aid'] == $var['countm']){ ?>
                <li>
                  <a href="<?php echo $sidenavmodules['link'];?>" title="<?php echo $lang[ $sidenavmodules['name'] ];?>"><?php echo $lang[ $sidenavmodules['name'] ];?></a>
                </li>
                <?php } ?>
                
              <?php } ?>
            <?php if($var['countm'] != -1){ ?>
                </ul>
                </div>
                <?php } ?>
          </div>
          </div>
          <?php } ?>
				</div>
				
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