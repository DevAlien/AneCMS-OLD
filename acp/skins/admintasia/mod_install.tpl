{content name="breadcrumb"}
<h1>{lang.modules}</h1>
<span><a href="?p=cfg" title="Layout Options">{lang.modules}</a> > <a href="#" title="">{lang.modadd}</a> > <a href="#" title="">{$name}</a></span>
{/content}
{content name="main"}
<div class="inner-page-title">
    <h3>{lang.name}</h3>
    <span>{$name}</span>
</div>
<div class="content-box">
  {if condition="[$result] == true"}
    <h5>{lang.mod_dloadcomplete}</h5>

                    <h5><a href="?p=mod&m=installmodule&name={$name}">{lang.install}</a></h5>
                    <br />
                    {else}
                    <h5>There's problem with the download of the file.</h5>
                    {/if}
    <div class="clear">
    </div>
</div>
{/content}