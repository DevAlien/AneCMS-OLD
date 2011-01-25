<li class="widget"><div>
{if condition="!isset($_SESSION['logged'])"}

			<h2 name="login">Login</h2>
                    <form name="prova" align="left" action="javascript:makelogin('{qg.url_base}'); ApriOscura();" method="POST">
                    <fieldset >
                        <label><p>Username:</p><input type="text" name="username" id="username" value="" /></label>
                        <label><p>Password:</p><input type="password" name="password" id="password" value="" /></label>
                        <p><a href="#" class="submit button">Login</a></p>
</fieldset>
                    </form>
            {else}
				<h2 name="login">Welcome</h2>
				<form name="prova" action="javascript:makelogout('{qg.url_base}'); ApriOscura();" method="POST">
                    {user.username}
                    <p>Vedi il tuo profilo</p>

                        
                        <p><a href="#" class="submit button">Logout</a></p>
                    </form>
{/if}
			</div></li>