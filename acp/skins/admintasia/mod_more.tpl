{content name="breadcrumb"}
<h1>{lang.modules}</h1>
<span><a href="?p=cfg" title="Layout Options">{lang.modules}</a> > <a href="#" title="">{lang.modadd}</a> > <a href="#" title="">{_moduleGetted.name}</a></span>
{/content}
{content name="main"}
<script type="text/javascript" src="./skins/admintasia/js/tablesorter.js">
</script>
<script type="text/javascript" src="./skins/admintasia/js/tablesorter-pager.js">
</script>
<script type="text/javascript">
    $(document).ready( function() {
        /* Table Sorter */
        $("#sort-table")
        .tablesorter({
            widgets: ['zebra'],
            headers: {
                // assign the secound column (we start counting zero)
                3: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },

            }
        })
        .tablesorterPager({container: $("#pager")});

        $(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');

    });

</script>
<div class="inner-page-title">
    <h3>{lang.name}</h3>
    <span>{_moduleGetted.name}</span>
</div>
<div class="content-box">
    <h5>{lang.description}: {_moduleGetted.description}</h5>
                    <h5>{lang.type}: {_moduleGetted.type}
                    <br />
                    <h5><a href="?p=mod&m=install&name={_moduleGetted.name}&t={_moduleGetted.type}">{lang.install}</a></h5>
                    <br />
    <div class="clear">
    </div>
</div>
{if condition="[$countDepends] > 0"}
<div class="inner-page-title">
    <h2>{lang.deps}</h2>
</div>
<div class="hastable">
    <div class="content-box">
        <form name="myform" class="pager-form" method="post" action="">
            <table id="sort-table">
                <thead>
                    <tr>
                        <th>{lang.name}</th>
                        <th>{lang.description}</th>
                        <th>{lang.type}</th>
                        <th width="180px">{lang.moreinfo}</th>
                </thead>
                <tbody>
                    {loop name="dependsGetted"}
                    {if condition="[counter.dependsGetted] %2 == 0"}
                    <tr class="alt">
                        {else}
                    <tr>
                        {/if}
                        <td>{$dependsGetted.name}</td>
                        <td>{$dependsGetted.description}</td>
                        <td>{$dependsGetted.type}</td>
                        <td valign="top"><a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.moreinfo}" href="?p=mod&m=more&id={$dependsGetted.id}">
                        <span class="ui-icon ui-icon-plusthick"></span>
                        </a></td>
                    </tr>
                    {/loop}

                </tbody>
            </table>
            <div class="clear">
            </div>
            <div class="clear">
            </div>
            <div id="pager">

                <a class="btn_no_text btn ui-state-default ui-corner-all first" title="First Page" href="#">
                <span class="ui-icon ui-icon-arrowthickstop-1-w"></span>
                </a>
                <a class="btn_no_text btn ui-state-default ui-corner-all prev" title="Previous Page" href="#">
                <span class="ui-icon ui-icon-circle-arrow-w"></span>
                </a>
                <input type="text" class="pagedisplay"/>
                <a class="btn_no_text btn ui-state-default ui-corner-all next" title="Next Page" href="#">
                <span class="ui-icon ui-icon-circle-arrow-e"></span>
                </a>
                <a class="btn_no_text btn ui-state-default ui-corner-all last" title="Last Page" href="#">
                <span class="ui-icon ui-icon-arrowthickstop-1-e"></span>
                </a>
                <select class="pagesize">
                    <option value="10" selected="selected">10 {lang.results}</option>
                    <option value="20">20 {lang.results}</option>
                    <option value="30">30 {lang.results}</option>
                    <option value="40">40 {lang.results}</option>
                </select>
                <br /><br />
            </div>
        </form>
    </div>
</div>
{else}
<h3>{lang.nodeps}</h3>
{/if}
{/content}