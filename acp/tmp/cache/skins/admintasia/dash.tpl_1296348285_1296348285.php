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
		<h1><?php echo $lang['dashboard'];?></h1>
			
		</div>
		</div>
		<div id="page-layout">
			<div id="page-content">
				<div id="page-content-wrapper">
					
<script type="text/javascript" src="./skins/admintasia/js/tablesorter.js"></script>
<script type="text/javascript" src="./skins/admintasia/js/tablesorter-pager.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	/* Table Sorter */
	$("#sort-table")
	.tablesorter({
		widgets: ['zebra'],
		headers: { 
		            // assign the secound column (we start counting zero) 
		            0: { 
		                // disable it by setting the property sorter to false 
		                sorter: false 
		            }, 
		            // assign the third column (we start counting zero) 
		            5: { 
		                // disable it by setting the property sorter to false 
		                sorter: false 
		            } 
		        } 
	})
	
	.tablesorterPager({container: $("#pager")}); 
	
	$(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');

	
});

 	/* Check all table rows */

var checkflag = "false";
function check(field) {
if (checkflag == "false") {
for (i = 0; i < field.length; i++) {
field[i].checked = true;}
checkflag = "true";
return "check_all"; }
else {
for (i = 0; i < field.length; i++) {
field[i].checked = false; }
checkflag = "false";
return "check_none"; }
}


</script>
<div class="inner-page-title">
    <h2>AneCMS News</h2>
</div>
<div class="content-box">
    <div class="two-column">
      <?php $counter_rss=0; foreach($var['rss'] as $key => $rss){ $counter_rss++; ?>
	<div class="column <?php if(($counter_rss %2 == 0)){ ?>column-right<?php } ?>">
            <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
                <div class="portlet-header ui-widget-header"><?php echo $rss['title'];?><span class="ui-icon ui-icon-circle-arrow-s"></span></div>
                <div class="portlet-content">
                    <?php echo $rss['description'];?>
                    
		</div>
            </div>
        </div>

	<?php } ?>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<div class="inner-page-title">
    <h2><?php echo $lang['adminlog'];?></h2>
</div>
<div class="hastable">
    <form name="myform" class="pager-form" method="post" action="">
						<table id="sort-table"> 
						<thead> 
						<tr>
						<th><input type="checkbox" value="check_none" onclick="this.value=check(this.form.list)" class="submit"/></th>
							<th><?php echo $lang['who'];?></th>
							<th><?php echo $lang['ip'];?></th>
							<th><?php echo $lang['when'];?></th>
							<th><?php echo $lang['txt'];?></th>
							<th style="width:128px"><?php echo $lang['options'];?></th> 
						</tr> 
						</thead> 
						<tbody> 
						
						<?php $counter_log=0; foreach($var['log'] as $key => $log){ $counter_log++; ?>
			    <tr class="odd">
				<td class="center"><input type="checkbox" value="<?php echo $log['id'];?>" name="list" class="checkbox"/></td> 
                                <td><?php echo $log['username'];?></td>
				<td><?php echo $log['ip'];?></td>
				<td><?php echo date('d-m-Y H:i',$log['date']);?></td>
				<td><?php echo $log['text'];?></td>
				<td>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Edit this example" href="#">
									<span class="ui-icon ui-icon-wrench"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Favourite this example" href="#">
									<span class="ui-icon ui-icon-heart"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Add to shopping card example" href="#">
									<span class="ui-icon ui-icon-cart"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Delete this example" href="#">
									<span class="ui-icon ui-icon-circle-close"></span>
								</a>
							</td>
                            </tr>
			<?php } ?>
						</tbody>
						</table>
						<div id="pager">
					
								<a class="btn_no_text btn ui-state-default ui-corner-all first" title="First Page" href="#">
									<span class="ui-icon ui-icon-arrowthickstop-1-w"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all prev" title="Previous Page" href="#">
									<span class="ui-icon ui-icon-circle-arrow-w"></span>
								</a>
							
								<input type="text" class="pagedisplay"/>
								<a class="btn_no_text btn ui-state-default ui-corner-all next" title="Next Page" href="#">
									<span class="ui-icon ui-icon-circle-arrow-e"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all last" title="Last Page" href="#">
									<span class="ui-icon ui-icon-arrowthickstop-1-e"></span>
								</a>
								<select class="pagesize">
									<option value="10" selected="selected">10 <?php echo $lang['results'];?></option>
									<option value="20">20 <?php echo $lang['results'];?></option>
									<option value="30">30 <?php echo $lang['results'];?></option>
									<option value="40">40 <?php echo $lang['results'];?></option>
								</select>								
						</div>
</form>
<div class="clear"></div>
<div class="clear"></div>
						</div>
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