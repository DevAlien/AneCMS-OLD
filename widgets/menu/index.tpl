<li class="widget"><div>
<h2 name="menu">Menu</h2>
			<ul class="sidemenu">
{loop name="sidemenu"}
<li><a href="{qg.url_base}{$sidemenu.link}">{$sidemenu.name}</a></li>
{/loop}

			</ul>
</div></li>