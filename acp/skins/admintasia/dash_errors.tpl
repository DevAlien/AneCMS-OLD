{content name="breadcrumb"}
	<h1>{lang.dashboard}</h1>
	<span><a href="index.php" title="Layout Options">{lang.dashboard}</a> > <a href="?m=errors" title="Elements">{lang.dashboard_errorslog}</a></span>
{/content}
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
    <h2>{lang.dashboard_errorslog}</h2>
</div>
<div class="hastable">
    <form name="myform" class="pager-form" method="post" action="">
						<table id="sort-table"> 
						<thead> 
						<tr>
						<th><input type="checkbox" value="check_none" onclick="this.value=check(this.form.list)" class="submit"/></th>
							<th style="width:100px">{lang.who}</th>
							<th style="width:100px">{lang.ip}</th>
							<th style="width:100px">{lang.when}</th>
							<th>{lang.txt}</th>
							<th style="width:64px">{lang.options}</th> 
						</tr> 
						</thead> 
						<tbody> 
						{loop name="errors"}
			    <tr class="odd">
				<td class="center"><input type="checkbox" value="{$log.id}" name="list" class="checkbox"/></td> 
                                <td>{$errors.logged}</td>
				<td>{$errors.ip}</td>
				<td>{date.$errors.date}</td>
				<td>{$errors.text}</td>
				<td>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Send this error" href="#">
									<span class="ui-icon ui-icon-contact"></span>
								</a>
								<a class="btn_no_text btn ui-state-default ui-corner-all tooltip" title="Delete this Error" href="#">
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
{/content}