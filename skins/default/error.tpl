<div class="forum">
	{if condition="isset($_SESSION['logged'])"}
	<h1><img src="{qg.url_base}system/images/correct.gif" onload="doRedirect('{$link}', 3000);" />{$compli}<img src="{qg.url_base}system/images/correct.gif" /></h1>
	{else}
	<h1>Errore!!</h1>
	{/if}
	{$error}
	<br>
	{$redirect}
</div>