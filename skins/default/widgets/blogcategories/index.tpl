<li class="widget"><div class="widgets"><h2 name="blogcategories" class="title">Archives</h2>		

					
						<ul>
{loop name="categories"}
              <li><a href="{qg.url_base}blog/{$categories.name}">{$categories.name}</a>({$categories.totale})</li>
            {/loop}
						</ul>
				</div>	
			
</li>