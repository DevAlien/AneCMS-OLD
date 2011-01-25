		{content name="breadcrumb"}<h1>{lang.dashboard}</h1>{/content}
			
			
{content name="main"}
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
      {loop name="rss"}
	<div class="column {if condition="([counter.rss] %2 == 0)"}column-right{/if}">
            <div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
                <div class="portlet-header ui-widget-header">{$rss.title}<span class="ui-icon ui-icon-circle-arrow-s"></span></div>
                <div class="portlet-content">
                    {$rss.description}
                    
		</div>
            </div>
        </div>

	{/loop}
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<div class="inner-page-title">
    <h2>{lang.adminlog}</h2>
</div>
<div class="hastable">
    <form name="myform" class="pager-form" method="post" action="">
						<table id="sort-table"> 
						<thead> 
						<tr>
						<th><input type="checkbox" value="check_none" onclick="this.value=check(this.form.list)" class="submit"/></th>
							<th>{lang.who}</th>
							<th>{lang.ip}</th>
							<th>{lang.when}</th>
							<th>{lang.txt}</th>
							<th style="width:128px">{lang.options}</th> 
						</tr> 
						</thead> 
						<tbody> 
						
						{loop name="log"}
			    <tr class="odd">
				<td class="center"><input type="checkbox" value="{$log.id}" name="list" class="checkbox"/></td> 
                                <td>{$log.username}</td>
				<td>{$log.ip}</td>
				<td>{date.$log.date}</td>
				<td>{$log.text}</td>
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
			{/loop}
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
									<option value="10" selected="selected">10 {lang.results}</option>
									<option value="20">20 {lang.results}</option>
									<option value="30">30 {lang.results}</option>
									<option value="40">40 {lang.results}</option>
								</select>								
						</div>
</form>
<div class="clear"></div>
<div class="clear"></div>
						</div>
				</div>
{/content}