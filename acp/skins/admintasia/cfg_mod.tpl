{content name="breadcrumb"}
	<h1>{lang.configuration}</h1>
	<span><a href="?p=cfg" title="Layout Options">{lang.configuration}</a> > <a href="?p=cfg&m=cfg" title="">{lang.modify}</a></span>
{/content}
{content name="main"}
<div class="hastable">
<div class="inner-page-title">
						<h3>{lang.configuration}</h3>{loop name="cfg"}
						
					</div>
<div class="content-box">
					<form action="?p=cfg&m=smod" method="post" enctype="multipart/form-data" class="forms" name="form" >
						<ul>
							<li>
								<label class="desc">
									{lang.site_title}
								</label>
								<div>
									<input type="text" tabindex="1" maxlength="255" value="{$cfg.title}" class="field text small" name="title" />
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.site_desc}
								</label>
								<div>
									<textarea tabindex="2" cols="50" rows="5" class="field textarea small" name="descr" >{$cfg.descr}</textarea>
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.site_open}
								</label>
								<div>
									<input type="checkbox" tabindex="3"  class="field checkbox" name="status" value="Yes" {if condition="[$cfg.status] == 1"}checked{/if}/>
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.site_toclose}
								</label>
								<div>
									<textarea tabindex="4" cols="50" rows="5" class="field textarea small" name="infoclosed" >{$cfg.infoclosed}</textarea>
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.lang_pred}
								</label>
								<div>
									<select tabindex="5" class="field select small" name="language" > 
									{$langpd}
									</select>
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.selectdefaultmodule}
								</label>
								<div>
									<select name="defaultmodule" tabindex="6" class="field select small">
									              <option value="" {if condition="[$cfg.default_module] == ''"}SELECTED{/if}>-</option>
                                {loop name="dmodule"}
                                    <option value="{$dmodule.name}" {if condition="[$dmodule.name] == [$cfg.default_module]"}SELECTED{/if}>{$dmodule.name}</option>
                                {/loop}
                            </select>
								</div>
							</li>
							<li>
								<label class="desc">
									{lang.url_base}
								</label>
								<div>
									<input type="text" tabindex="7" maxlength="255" value="{$cfg.url_base}" class="field text small" name="url_base" />
								</div>
							</li>
							{csrftoken}
							<li class="buttons">
								<button class="ui-state-default ui-corner-all ui-button" type="submit">{lang.upd_general}</button>
							</li>
						</ul>
					</form>
					<div class="clear"></div>
				</div>
{/loop}
</div>
{/content}