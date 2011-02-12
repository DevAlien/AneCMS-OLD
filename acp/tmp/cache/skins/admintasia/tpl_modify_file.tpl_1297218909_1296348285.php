<h3><?php echo $lang['tplmodnow'];?> <?php echo $var['filename'];?></h3>
<form action="javascript: savetpl();"  method="POST" id="form">
<input type="hidden" value="<?php echo $var['tpl'];?>" name="filelink" id="filelink" />
<input type="hidden" value="<?php echo $var['filename'];?>" name="fname" id="fname" />
<textarea rows="1" cols="1" name="notes" id="notes"><?php echo $var['filecontent'];?></textarea>
<input type="submit" value="<?php echo $lang['submit'];?>" />
</form>		
<br />
