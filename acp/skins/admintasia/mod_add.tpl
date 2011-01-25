{content name="breadcrumb"}
<h1>{lang.modules}</h1>
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
    <h3>{lang.addrepository}</h3>
    <span>{lang.addrepositorydesc}</span>
</div>
<div class="content-box">
    <form action="?p=mod&m=search" method="post" enctype="multipart/form-data" class="forms" name="form" >
        <ul>
            <li>
                <label class="desc">
                    {lang.word}
                </label>
                <div>
                    <input type="text" tabindex="0" maxlength="255" value="" class="field text small" name="word" />
                </div>
            </li>
            <li>
                <label class="desc">
                    {lang.server}
                </label>
                <div>
                    <select tabindex="1" class="field select small" name="urlserver">
                        {loop name="selectsrv"}<option value="{$selectsrv.url}">{$selectsrv.url}</option>{/loop}
                    </select>
                </div>
            </li>
            <li class="buttons">
                <button class="ui-state-default ui-corner-all ui-button" type="submit">
                    {lang.search}
                </button>
            </li>
        </ul>
    </form>
    <div class="clear">
    </div>
</div>
{if condition="isset($_POST['word'])"}
<div class="inner-page-title">
    <h2>{lang.modinstalled}</h2>
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
                        <th width="64px">{lang.moreinfo}</th>
                </thead>
                <tbody>
                    {loop name="results"}
                    {if condition="[counter.results] %2 == 0"}
                    <tr class="alt">
                        {else}
                    <tr>
                        {/if}
                        <td>{$results.name}</td>
                        <td>{$results.description}</td>
                        <td>{$results.type}</td>
                        <td valign="top"><a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.moreinfo}" href="?p=mod&m=more&id={$results.id}">
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
            </div>
        </form>
    </div>
</div>
{/if}
{/content}