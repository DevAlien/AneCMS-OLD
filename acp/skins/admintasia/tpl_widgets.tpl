{content name="breadcrumb"}
	<h1>{lang.templates}</h1>
	<span><a href="?p=cfg" title="Layout Options">Widgets</a> > <a href="?p=cfg&m=reposerver" title="">{lang.insert}</a></span>
{/content}
{content name="main"}

<div class="inner-page-title">
						<h3>{lang.tplselect}</h3>	
<span>{lang.tplselectdesc}</span>						
					</div>
<div class="content-box">
					<form action="?p=mod&m=search" method="post" enctype="multipart/form-data" class="forms" name="form" >
						<ul>
							<li>
								<label class="desc">
									{lang.inserturl}
								</label>
								<div>
									<select tabindex="4" class="field select small" name="templatename" id="templatename" onChange="selecttpl()">
										<option value="0">{lang.select}</option>
										{loop name="templates"}
											<option value="{$templates.name}">{$templates.name}</option>
										{/loop}
									</select>
								</div>
							</li>
						</ul>
					</form>
					<div class="clear"></div>
				</div>


<div class="hastable" id="table">
</div>
{/content}