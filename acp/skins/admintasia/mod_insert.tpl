{content name="breadcrumb"}
	<h1>{lang.configuration}</h1>
	<span><a href="?p=cfg" title="Layout Options">{lang.configuration}</a> > <a href="?p=cfg&m=reposerver" title="">{lang.insert}</a></span>
{/content}
{content name="main"}

<div class="inner-page-title">
						<h3>{lang.addrepository}</h3>  
<span>{lang.addrepositorydesc}</span>    			
					</div>
<div class="content-box">
					<form action="?p=cfg&m=reposerver" method="post" enctype="multipart/form-data" class="forms" name="form" >
						<ul>
							<li>
								<label class="desc">
									{lang.inserturl}
								</label>
								<div>
									<input type="text" tabindex="1" maxlength="255" value="" class="field text small" name="url" />
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
						<h3>{lang.reposlist}</h3>
						<span>{lang.reposlistdesc}</span>
					</div>	
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<th>{lang.serverurl}</th>
								<th width="32px">{lang.delete}</th>
							</tr>
						</thead>
						<tbody>
							{loop name="reposervers"}
				
					<tr>
                                <td>{$reposervers.url}</td>
								<td>
								<a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.delete}" href="?p=cfg&m=reposerver&d={$reposervers.id}">
										<span class="ui-icon ui-icon-circle-close"></span>
									</a>
                            </tr>
				{/loop}
							
						</tbody>
                    </table>
				</div>

</div>
{/content}