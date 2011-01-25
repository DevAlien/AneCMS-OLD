<li class="widget"><div class="widgets"><h2 name="login" class="title">Login</h2>		

					{if condition="!isset($_SESSION['logged'])"}
						<form name="prova" align="left" action="javascript:makelogin('{qg.url_base}'); ApriOscura();" method="POST">
                    <p>Username:</p><input type="text" name="username" id="username" value="" />
                        <p>Password:</p><input type="password" name="password" id="password" value="" />
                        <p><input type="submit" class="submit button" value="Login" /></p>
                    </form>
            {else}
				<h2 name="login">Welcome</h2>
				<form action="javascript:makelogout('{qg.url_base}'); ApriOscura();" method="POST">
                    {user.username}
                    <p>Vedi il tuo profilo</p>
                    <p><input type="submit" class="submit button" value="Logout" /></p>
                    </form>
{/if}
				</div>

</li>