{content name="breadcrumb"}
	<h1>{lang.modules}</h1>
	<span><a href="?p=mod&mod=users" title="{lang.users}">{lang.users}</a> > <a href="#" title="{lang.modify}">{lang.modify}</a></span>
{/content}
{content name="main"}
{loop name="user"}
    <script type="text/javascript" src="skins/admintasia/js/ui/ui.draggable.js"></script>
    <script type="text/javascript" src="skins/admintasia/js/ui/ui.droppable.js"></script>
    <!--[if lt IE 9]>
      <script src=http://html5shiv.googlecode.com/svn/trunk/html5.js></script>
    <![endif]-->
    <style type="text/css">
      .custom-state-active { background: #eee; }
      .usergroups { padding:5px; }
      .ugb { cursor: move;}
    </style>
    <script type="text/javascript">
      $(function() {
        // there's the gallery and the trash
        var $usergroups = $('#usergroups');
        var $rusergroups = $('#remainedusergroups');
        
        // let the gallery items be draggable
        $('a',$('.usergroups')).draggable({
          cancel: 'a.ui-icon',// clicking an icon won't initiate dragging
          revert: 'invalid', // when not dropped, the item will revert back to its initial position
          containment: $('#demo-frame').length ? '#demo-frame' : 'document', // stick to demo-frame if present
          helper: 'original',
          cursor: 'move'
        });

        // let the gallery be droppable as well, accepting items from the trash
        $usergroups.droppable({
          accept: '.rug > a',
          activeClass: 'custom-state-active',
          drop: function(ev, ui) {
            addGroup(ui.draggable);
          }
        });
        
        $rusergroups.droppable({
          accept: '.ug > a',
          activeClass: 'custom-state-active',
          drop: function(ev, ui) {
            removeGroup(ui.draggable);
          }
        });
        
        function addGroup($item) {
          var b = $item.attr('id');
            b = b.replace('group', '');
            var sp = $item.children().attr('id');
            $.post("../index.php?mode=users&ajax=addgrouptouser", { iduser: {$iduser}, idgroup: b } );
            $.jGrowl("The group " + sp + " has been added to the user.",  {
              theme: 'green',
              header: "Group Added"
            });
          $item.fadeOut(function() {
            $item.css('left','0').css('top', '0').appendTo($usergroups).fadeIn();
          });
        };
        
        function removeGroup($item) {
          var b = $item.attr('id');
            b = b.replace('group', '');
            var sp = $item.children().attr('id');
            $.post("../index.php?mode=users&ajax=removegroupfromuser", { iduser: {$iduser}, idgroup: b } );
            $.jGrowl("The group " + sp + " has been removed from the user.",  {
              theme: 'green',
              header: "Group removed"
            });
          $item.fadeOut(function() {
            $item.css('left','0').css('top', '0').appendTo($rusergroups).fadeIn();
          });
        };
        
      });
        </script>
<div class="inner-page-title">
						<h3>{lang.users}</h3>
						<span>{lang.users_modifying} {$user.username}</span>
					</div>
<div class="content-box">
  
  <form action="?p=mod&mod=users&m=users&t=update&id={$user.id}" method="post" enctype="multipart/form-data" class="forms" name="form" >
            <ul>
              <li>
                <label class="desc">
                  {lang.users_username}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="username"  value="{$user.username}"/>
                </div>
              </li>
              <li>
                <label class="desc">
                  {lang.users_email}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="email"  value="{$user.email}"/>
                </div>
              </li>
              <li>
                <label class="desc">
                  {lang.users_web}
                </label>
                <div>
                <input type="text" tabindex="1" maxlength="255" class="field text small" name="web"  value="{$user.web}"/>
                </div>
              </li>
              <li>
                <label class="desc">
                  {lang.users_password}
                </label>
                <div>
                <input type="password" tabindex="1" maxlength="255" class="field text small" name="password" />
                </div>
              </li>
              <li class="buttons">
                <button class="ui-state-default ui-corner-all ui-button" type="submit">{lang.submit}</button>
              </li>
              </ul>
                
                        
                        </form>
					<div class="clear"></div>{/loop}
				</div>
<div class="inner-page-title">
            <h3>{lang.users_assigngroups}</h3>
            <span>{lang.users_assigngroupsdesc}</span>
          </div>
        <div class="two-column">
          <div class="column">
          <div class="content-box">
              <h3>{lang.users_assignedgroupstouser}</h3>
              <div id="usergroups" class="content usergroups ug">
                {loop name="usergroups"}
              
                <a id="group{$usergroups.id}" class="btn ui-state-default full-link ui-corner-all ugb" href="#">
                <span id="{$usergroups.name}" class="ui-icon ui-icon-arrow-4-diag"></span>
                {$usergroups.name} - {$usergroups.description}
              </a>
                
              {/loop}
              
            </div>
            </div>
          </div>
          <div class="column column-right">
            <div id="albums" class="content-box">
              <h3>{lang.users_availablegroups}</h3>
              <div id="remainedusergroups" class="content usergroups rug">
                {loop name="remainedusergroups"}
              
                <a id="group{$remainedusergroups.id}" class="btn ui-state-default full-link ui-corner-all ugb" href="#">
                <span id="{$remainedusergroups.name}" class="ui-icon ui-icon-arrow-4-diag"></span>
                {$remainedusergroups.name} - {$remainedusergroups.description}
              </a>
                
              {/loop}
              
            </div>
            </div>
          </div>
        </div>
{/content}