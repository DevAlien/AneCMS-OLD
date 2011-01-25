{content name="main"}
<div id="comments">
<div id="commentop">
</div>
<div id="commentcontent">
  <form action="{qg.url_base}register/next" method="post" >
    <p>
        <label for="author">{lang.username}</label>

      <input class="text" name="username" id="author" value="" size="22" tabindex="1" type="text" />
    </p>
    <p>
        <label for="email">E-Mail:</label>

      <input class="text"  name="email" id="email" value="" size="22" tabindex="2" type="text" />
    </p>
    <p>
        <label for="url">Password:</label>

      <input class="text"  name="password" id="url" value="" size="22" tabindex="3" type="text" />
    </p>
    <p>
        <label for="url">{lang.ripeti}</label>

      <input class="text"  name="rpassword" id="url" value="" size="22" tabindex="3" type="text" />
    </p>
    <p>
        <label for="url">{lang.lingua}</label>

      <select name="language">
                     <option value="choose"> {lang.scegli} </option>
                     <option value="it"> {lang.it} </option>
                     <option value="en"> {lang.en} </option>
           </select>
    </p>
    <p>
      <input name="submit" alt="submit" src="{qg.url_base}skins/default/images/submit.jpg" id="submit" tabindex="5" value="Register" type="image" />
    </p>
  </form>
</div>

<div id="commentbtm">
</div>
</div>
{/content}
