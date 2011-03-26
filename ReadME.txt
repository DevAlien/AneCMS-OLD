INTRODUCTION

AneCMS is a light-weight open-source content management system (CMS) written in PHP 5 (compatible with PHP 4). It utilises a MySQL database to store your site content and includes a simple, comprehensive administration system. AneCMS includes the most common features you would expect to see in many other CMS packages.

INSTALLATION

Before installing AneCMS you need to create a MySQL database. You can do this via your web-hosting control panel or phpMyAdmin. Make sure you have your mysql access details at hand including the hostname, username, password and database name as you will need to specify these during setup.

1. Upload the contents of the AneCMS folder to your web server.

3. Unless you run AneCMS on a local server, in most cases you will need to CHMOD the following files and folders to 777:

./tmp/	
./modules/	
./acp/skins/admintasia/	
./skins/default/	
./lang/en/main.php/	
./lang/en/admin.php/

Note: Some hosts doesn't allow CHMOD 777, in that case you can use CHMOD 755 if CHMOD 777 fails.

4. Go to your website, and you will be redirected to the Smart installer. If not, you should run the installer script manually by entering your full site url followed by /install/. Example: http://www.yourdomain.com/insatll/

5. Complete the setup process by following all on-screen prompts.

6. Immediately after completing the installation of AneCMS delete the director install from your web server. Failure to do so could lead to someone else taking control of your site.

IMPORTANT NOTE 


You are not permitted to remove these copyright notices:
/*-------------------------------------------------------+
| AneCMS
| Copyright (C) 2010
| http://anecms.com
+--------------------------------------------------------+
| Filename: error.php
| Author: Gonçalo Margalho
+--------------------------------------------------------+
| Removal of this copyright header is strictly 
| prohibited without written permission from 
| Gonçalo Margalho.
+--------------------------------------------------------*/

Powered by AneCMS copyright © 2010 - 2011 by Gonçalo Margalho.


