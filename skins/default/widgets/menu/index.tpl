<li class="widget"><div class="widgets"><h2 name="menu" class="title">Menu</h2>   
            <ul>
{loop name="sidemenu"}
<li><a href="{qg.url_base}{$sidemenu.link}">{$sidemenu.name}</a></li>
{/loop}

            </ul>
        </div>  
</li>
