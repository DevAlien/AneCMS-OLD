    <li class="widget">
        <div class="widget_categories">
            <h2 name="blogcategories">Categories</h2>
            <ul>
            {loop name="categories"}
              <li><a href="{qg.url_base}blog/{$categories.name}">{$categories.name} ({$categories.totale})</a></li>
            {/loop}
            </ul>
          </div>
</li>