<li class="widget"><div>
<?php if(!isset($_SESSION['logged'])){ ?>

			<h2 name="login">Login</h2>
                    <form name="prova" align="left" action="javascript:makelogin('<?php echo $qgeneral['url_base'];?>'); ApriOscura();" method="POST">
                    <fieldset >
                        <label><p>Username:</p><input type="text" name="username" id="username" value="" /></label>
                        <label><p>Password:</p><input type="password" name="password" id="password" value="" /></label>
                        <p><a href="#" class="submit button">Login</a></p>
</fieldset>
                    </form>
            <?php } else{ ?>
				<h2 name="login">Welcome</h2>
				<form name="prova" action="javascript:makelogout('<?php echo $qgeneral['url_base'];?>'); ApriOscura();" method="POST">
                    <?php echo $user->getValues('username');?>
                    <p>Vedi il tuo profilo</p>

                        
                        <p><a href="#" class="submit button">Logout</a></p>
                    </form>
<?php } ?>
			</div></li>