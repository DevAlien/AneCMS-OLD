{content name="breadcrumb"}
	<h1>{lang.modules}</h1>
	<span><a href="?p=mod&mod=users" title="{lang.users}">{lang.users}</a> > <a href="?p=mod&mod=users" title="{lang.users_management}">{lang.users_management}</a></span>
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
						<h3>{lang.users}</h3>
						<span>{lang.users_management}</span>
					</div>
<div class="content-box">
  
  <form action="?p=mod&mod=users&t=search" method="post" enctype="multipart/form-data" class="forms" name="form" >

<h3>{lang.users_finduser}</h3>
            <ul>
              <li>
                <label class="desc">
                  {lang.users_username}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="name" />
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
						<h3>{lang.users_userslist}</h3>
					</div>	
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<th>{lang.users_username}</th>
								<th>{lang.status}</th>
                <th width="128px">{lang.options}</th>
							</tr>
						</thead>
						<tbody>
              {loop name="users"}
							<tr>
                                <td>{$users.username}</td>
								<td>{$users.status}</td>
								<td>
									<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.modify}" href="?p=mod&mod=users&m=users&t=modify&id={$users.id}">
										<span class="ui-icon ui-icon-wrench"></span>
									</a>
									<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.delete}" href="?p=mod&mod=users&m=users&t=delete&id={$users.id}">
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