{content name="breadcrumb"}
	<h1>{lang.modules}</h1>
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
		            2: {
		                // disable it by setting the property sorter to false
		                sorter: false
		            },
		            
		        }
	})

	

	$(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');


});

</script>

<div class="inner-page-title">
    <h2>{lang.modinstalled}</h2>
</div>
<div class="hastable">
<div class="content-box">
  {if condition="[$message] != '0'"}
  <div class="response-msg success ui-corner-all">
            <span>{$message_title}</span>
            {$message}
          </div>
          {/if}
    <form name="myform" class="pager-form" method="post" action="">
						<table id="sort-table">
						<thead>
						<tr>
						<th>{lang.name}</th>
                                                <th>{lang.description}</th>
                                                 <th>{lang.options}</th>
						</thead>
						<tbody>
					{loop name="modules"}
                    {if condition="[$modules.status] == 1"}
                            <tr class="oddgreen">
                                <td>{$modules.name}</td>
                                <td><?php echo $lang[ [$modules.name].'_description' ];?></td>
                                <td><a href="?p=mod&deactive={$modules.id}">{lang.disable}</a></td>
                    {elseif condition="[$modules.status] == 0"}
                        <tr class="oddred">
                            <td>{$modules.name}</td>
                                <td><?php echo $lang[ [$modules.name].'_description' ];?></td>
                                <td><a href="?p=mod&active={$modules.id}">{lang.enable}</a></td>
                    {else}
                        <tr class="odd">
                            <td>{$modules.name}</td>
                                <td>{$modules.description}</td>
                                <td> </td>
                    {/if}

                            </tr>
                    {/loop}

						</tbody>
						</table>
						
</form>
</div>
</div>
{/content}