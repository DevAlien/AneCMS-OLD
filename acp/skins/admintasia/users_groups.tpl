{content name="breadcrumb"}
	<h1>{lang.modules}</h1>
	<span><a href="?p=mod&mod=users" title="{lang.users}">{lang.users}</a> > <a href="?p=mod&mod=users&m=groups" title="{lang.users_groupsmanagement}">{lang.users_groupsmanagement}</a></span>
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
                3: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },
                
            }
  })

  

  $(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');


});

</script>
<div class="inner-page-title">
						<h3>{lang.users_ceatenewgroup}</h3>
					</div>
<div class="content-box">
  
  <form action="?p=mod&mod=users&m=groups&t=add" method="post" enctype="multipart/form-data" class="forms" name="form" >
            <ul>
              <li>
                <label class="desc">
                  {lang.users_groupname}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="name" />
                </div>
              </li>
               <li>
                <label class="desc">
                  {lang.users_groupdescription}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="description" />
                </div>
              </li>
              <li class="buttons">
                <button class="ui-state-default ui-corner-all ui-button" type="submit">{lang.submit}</button>
              </li>
              </ul>
                
                        
                        </form>
					<div class="clear"></div>
				</div>


<div class="hastable">
<div class="inner-page-title">
						<h3>{lang.users_groupslist}</h3>
					</div>	
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<th>{lang.name}</th>
								<th>{lang.description}</th>
                <th width="128px">{lang.options}</th>
							</tr>
						</thead>
						<tbody>
              {loop name="groups"}
							<tr>
                                <td>{$groups.name}</td>
								<td>{$groups.description}</td>
								<td>
									<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.delete}" href="?p=mod&mod=users&m=groups&t=delete&id={$groups.id}">
										<span class="ui-icon ui-icon-circle-close"></span>
									</a>
								</td>
                            </tr>
							{/loop}
						</tbody>
                    </table>
                    <div class="clear"></div>
            <div class="clear"></div>
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
            <br /><br />
				</div>

</div>
{/content}