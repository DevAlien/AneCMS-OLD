    <li class="widget">
        <div class="widget_categories">
            <h2 name="blogcategories">Categories</h2>
            <ul>
            <?php $counter_categories=0; foreach($var['categories'] as $key => $categories){ $counter_categories++; ?>
              <li><a href="<?php echo $qgeneral['url_base'];?>blog/<?php echo $categories['name'];?>"><?php echo $categories['name'];?> (<?php echo $categories['totale'];?>)</a></li>
            <?php } ?>
            </ul>
          </div>
</li>