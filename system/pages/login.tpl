<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>AneCMS - Login</title>
<meta name="author" content="AneCMS" />
<meta name="copyright" content="Copyright 2010 AneCMS Group." />
<style>
body {
	font-family: Verdana, Arial, sans-serif;
	font-size: 12px;
	background: #efefef;
	color: #000000;
	margin: 0;
}

a {
	color: #035488;
	text-decoration: none;
}

a:hover {
	color: #444;
	text-decoration: underline;
}

.invisible {
	display: none;
}

#container {
	width: 410px;
	margin: 100px auto;
}

#logo h1 {
	height: 82px;
	background: transparent url(system/images/ane2.png) bottom left no-repeat;
	margin: 10px;
	padding: 0;
}

#header h1 a {
	float: left;
	height: 82px;
	width: 410px;
}

#content {
	border: 2px solid #ccc;
	background: #fff;
}

p, form {
	padding: 0 10px 10px 10px
}

form {
	padding-bottom: 0;
}

p {
	margin-bottom: 0;
}

form p {
	padding: 0 0 10px 0;
}

h2 {
	background: #016DB1 repeat-x top left;
	border-bottom: 1px solid #000000;
	color:#fff;
	margin: 0;
	padding: 8px;
	font-size: 12px;
}

input.text_input {
	border: 1px solid #0F5C8E;
	background: #fff;
	width: 275px;
	padding: 4px;
	font-size: 13px;
}

input.text_input:focus {
	border: 1px solid #000;
}

#message {
	margin: 10px 10px 0 10px;
	padding: 10px;
	font-weight: bold;
	background: #efefef;
	border: 1px solid #ccc;
}

#message.error {
	border: 1px solid #FC6;
	background: #FFC;
	color: #C00;
}

#message.success {
	border: #080 1px solid;
	background-color: #E8FCDC;
	color: #080;
}

form .label {
	margin-top: 5px;
	margin-bottom: 3px;
	width: 100px;
	clear: left;
	float: left;
	padding-bottom:5px;
}

form label {
	font-weight: bold;
}

.form_container .field{
	float: left;
	padding-bottom: 5px;
}

p.submit {
	clear: both;
	padding-top: 8px;
	margin-top: 8px;
	margin-right: 0;
	padding-right: 0;
	text-align: right;
}

p.submit input {
	border: 3px double #0F5C8E;
	padding: 3px;
	background: #fff repeat-x top;
	color: #0F5C8E;
	font-weight: bold;
	margin-right: 3px;
}

.forgot_password {
	float: left;
	padding-top: 8px;
	font-size: 11px;
}

.forgot_password a {
	color: #555;
}
</style>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="logo">
			<h1><a href="{$qgeneral.url_base}" title="Return to forum"><span class="invisible">AneCMS Login</span></a></h1>
		</div>
	</div>
	<div id="content">
		<h2>Please Login</h2>
                <br />
		<form method="post" action="?normal=1">
		<div class="form_container">
			<div class="label"><label for="username">Username:</label></div>

			<div class="field"><input type="text" name="username" id="username" class="text_input initial_focus" /></div>

			<div class="label"><label for="password">Password:</label></div>
			<div class="field"><input type="password" name="password" id="password" class="text_input" /></div>
		</div>
		<p class="submit">
			<input type="checkbox" value="rememberme" name="remember">Remember me
			<input type="submit" value="Login" />
			<input type="hidden" name="do" value="login" />
		</p>
		</form>
	</div>
</div>
</body>
</html>
