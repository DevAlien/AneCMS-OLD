{content name="breadcrumb"}
	<h1>{lang.configuration}</h1>
	<span><a href="?=cfg" title="Layout Options">{lang.configuration}</a></span>
{/content}
{content name="main"}
<div class="hastable">
<div class="inner-page-title">
						<h3>Configuration Overview</h3>
						{loop name="cfg"}
						<span>{lang.cfg_cms}{if condition="[$cfg.status] == 1"}<font color="green"> {lang.open}</font>{else}<font color="red"> {lang.close}</font>{/if}</span>
					</div>
					
					
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<td>{lang.description}</td>
								<td>{lang.value}</td>
							</tr>
						</thead>
						<tbody>
							<tr>
                                <td>{lang.site_title}</td>
                                <td>{$cfg.title}</td>
                            </tr>
							<tr class="alt">
                                <td>{lang.site_desc}</td>
                                <td>{$cfg.descr}</td>
                            </tr>
							<tr>
                                <td>{lang.lang_pred}</td>
                                <td>{$cfg.language}</td>
                            </tr>
							<tr class="alt">
                                <td>{lang.def_mod}</td>
                                <td>{$cfg.default_module}</td>
                            </tr>
							<tr>
                                <td>{lang.url_base}</td>
                                <td>{$cfg.url_base}</td>
                            </tr>
						</tbody>
					</table>

				</div>
{/loop}
</div>
{/content}