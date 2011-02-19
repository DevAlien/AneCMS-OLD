{content name="breadcrumb"}
<script type="text/javascript">
  // When the document is ready set up our sortable with it's inherant function(s)
  $(document).ready(function() {
    $("#linksbar-menu").sortable({
	axis: "y",
      handle : '.handle',
	  cursor: "move",
	  items: 'tr',
      update : function () {
		  var order = $('#linksbar-menu').sortable('serialize');
  		$("#info").load("../index.php?ajax=sortmenus&"+order);
      }
    });
});
</script>
	<h1>{lang.configuration}</h1>
	<span><a href="?p=cfg" title="Layout Options">{lang.configuration}</a> > <a href="?p=cfg&m=cfg" title="">{lang.links}</a></span>
{/content}
{content name="main"}
<div class="inner-page-title">
						<h3>{lang.linkadd}</h3>
						
						
						
					</div>
<div class="content-box">
					<form action="?p=cfg&m=links&id={$update}" method="post" enctype="multipart/form-data" class="forms" name="form" >
						<ul>
							<li>
								<label class="desc">
									{lang.linkname}
								</label>
								<div>
									<input type="text" tabindex="1" maxlength="255" value="{$nam}" class="field text small" name="name" />
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.linklink}
								</label>
								<div>
									<input type="text" tabindex="2" maxlength="255" value="{$link}" class="field text small" name="link" />
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.linktype}
								</label>
								<div>
									<input type="radio" tabindex="3" class="field" name="type" value="1" checked>{lang.linkbar} <input type="radio" class="field" name="type" value="2">{lang.linkmenu}
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.access}
								</label>
								<div>
									<select name="view" tabindex="4" class="field select small">
										 <option value="0">{lang.cfg_vissibleonlyguest}</option>
										<option value="1">{lang.cfg_vissibleall}</option>
										<option value="2">{lang.cfg_vissibleonlymember}</option>
										<option value="3">{lang.cfg_vissibleaadmin}</option>
									</select>
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
<pre>
<div id="info">Waiting for update</div>
</pre>

						<h3>{lang.links_overview}</h3>
					</div>	
				<div class="content-box">
				
					<table cellspacing="0">
						<thead>
							<tr>
								<th width="30px">#</th>
								<th>{lang.name}</th>
								<th width="*">{lang.link}</th>
                                <th width="128px">{lang.options}</th>
							</tr>
						</thead>
						<tbody id="linksbar-menu">
							
							{loop name="linksbar"}
							<tr id="listItem_{$linksbar.id}" width="100%">
								<td><a class="btn ui-state-default ui-corner-all handle" style="cursor: move;"><span class="ui-icon  ui-icon-arrow-2-n-s"></span>&nbsp;</a></li>
                                <td>{$linksbar.name}</td>
								<td>{$linksbar.link}</td>
								<td>
									<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.modify}" href="?p=cfg&m=links&a=modify&id={$linksbar.id}">
										<span class="ui-icon ui-icon-wrench"></span>
									</a>
									<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.delete}" href="?p=cfg&m=links&a=delete&id={$linksbar.id}">
										<span class="ui-icon ui-icon-circle-close"></span>
									</a>
									
								</td>
                            </tr>
							{/loop}
						</tbody>
                    </table>
				</div>

</div>
{/content}