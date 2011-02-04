<?php
session_start();
if(isset($_SESSION['langa']))
  $la = $_SESSION['langa'];
else if(isset($_GET['lang']))
  $la = $_SESSION['langa'] = $_GET['lang'];
else
  $la = 'en';
include './lang/'.$la.'/install.php';
if(isset($_GET['toinstall'])){
function check(){
	$v = '<table><tr><td>module</td><td>install?</td></tr>';
  if ($handle = opendir('../tmp/toinstall/')) {
    while (false !== ($file = readdir($handle))) {
      if (($file != "." && $file != "..") && !is_dir($file)) {	
	$f = explode('.php', $file);
        $v .= '<tr><td>'.$f[0].'</td><td><input type="checkbox" name="toinstall[]" value="'.$f[0].'"/></td></tr>';
	}
}
}
$v .= '</table>';
return $v;
}
?>
</head><body>
<center>
    <h1>AneCMS - Installer</h1>
    <h2>Version 1.0 BETA</h2>
	</center>
	<div id="smartwizard" class="wiz-container">
		
		<div id="wizard-body" class="wiz-body">
		<div id="wizard-6" >
           <div class="wiz-content">
                <div id="modules"><?php echo check(); ?></div>
            </div>        
            <div class="wiz-nav">
             <div id="errMsg22" class="error" ></div> <input class="next btn" id="next" type="button" value="Next >" />
            </div>          
        </div>
</div>
</body>
</html>
<?php }


else{
$files = array();
$files['tmp'] = '../tmp';
if(file_exists('../tmp/toinstall')){
  $files['toinstall'] = '../tmp/toinstall';
}
$files['modules'] = '../modules';
$files['admintasia'] = '../acp/skins/admintasia';
$files['default'] = '../skins/default';
$files['langenmain'] = '../lang/en/main.php';
$files['langenadmin'] = '../lang/en/admin.php';
if(isset($_GET['chk'])){
  global $files;
  $v = 0;
  foreach ($files as $key => $value) {
    
      $v .= ((((substr(sprintf('%o', fileperms($value)), -3)) == 777) || ((substr(sprintf('%o', fileperms($value)), -3)) == 666)) ? ($v) : ($v+1));
  }
  echo ($v > 0) ? 'NO' : 'OK';
  die();
}
if(isset($_GET['chp'])){
  global $files;
  $v = '<tr><td>'.$l['file'].'</td><td>'.$l['status'].'</td></tr>';
  foreach ($files as $key => $value) {
    echo (substr(sprintf('%o', fileperms($value)), -3));
      $v .= '<tr><td>'.str_replace('../', './',$value).'/'.'</td><td>'.((((substr(sprintf('%o', fileperms($value)), -3)) == 777) || ((substr(sprintf('%o', fileperms($value)), -3)) == 666)) ? '<span style="color: green">OK</span>' : '<span style="color: red">NOT OK').'</td></tr>';
  }
  echo $v;
  die();
}


$pageurl = str_replace('install/index.php','' , 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);

function getLanguages(){
  $v = '<select id="lan">';
  if ($handle = opendir('./lang'))
  while (false !== ($file = readdir($handle))){

      if(file_exists('./lang/'.$file.'/install.php'))
                          $v .= '<option value="'.$file.'">'.$file.'</option>';
}
  $v .= '</select>';
  return $v;
}

function checkPerms(){
  global $files;
  $v = '<tr><td>'.$l['file'].'</td><td>'.$l['status'].'</td></tr>';
  foreach ($files as $key => $value) {
    
      $v .= '<tr><td>'.str_replace('../', './',$value).'/</td><td>'.((((substr(sprintf('%o', fileperms($value)), -3)) == 777) || ((substr(sprintf('%o', fileperms($value)), -3)) == 666)) ? '<span style="color: green">OK</span>' : '<span style="color: red">NOT OK').'</td></tr>';
  }
  return $v;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SmartWizard</title>

<link href="styles/style_wizard.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/SmartWizard.js"></script>
<script type="text/javascript" src="js/jquery.progressbar.min.js"></script>
<script type="text/javascript">
$().ready(function() {
        $("#pb1").progressBar(20);
    $('.wiz-container').smartWizard(
      {selectedStep: <?php echo (isset($_GET['lang'])) ? '1' : '0'; ?>,
      validatorFunc:validateTabs}
    );
}); 
function a(c){
return document.getElementById(c);
}
function validateTabs(tabIdx){
  var ret = true;
  switch(tabIdx){    
    case 0:
        window.location = "?lang="+a('lan').value;
		ret = true;
      break;
      case 1:
      $.ajaxSetup({async:false});
      $.post("./index.php?chp=1", { },function(data){
        a('t').innerHTML= data;
        });
        $.ajaxSetup({async:false});
        $.post("./index.php?chk=1", { },function(data){
          if(data == "OK" ){
          document.getElementById("errMsgx").innerHTML="";
          document.getElementById("errMsgx").style.display='none';
        ret = true;
        }
        else{
        document.getElementById("errMsgx").innerHTML="Set the permissions of the directories above to 777";
        $("#errMsgx").effect("highlight");
        ret = false;
        }
        });
      break;
    case 2:
		if(a('title').value != '' && a('baseurl').value != '' && a('description').value != '' && a('username').value != '' && a('password').value != '' && a('email').value != ''){
			document.getElementById("errMsg1").innerHTML="";
          document.getElementById("errMsg1").style.display='none';
			ret = true;
			
      
      
      
			}
		else{
			document.getElementById("errMsg1").innerHTML="Please fill all entries.";
			$("#errMsg1").effect("highlight");
			ret = false;
			}
        
      break;
    case 3:
    $.ajaxSetup({async:false});
      $.post("./check.php?check=2", { lang: a('lan').value, dbhostname: a('dbhostname').value, dbusername: a('dbusername').value, dbpassword: a('dbpassword').value, dbdatabase: a('dbdatabase').value, prefix: a('prefix').value },function(data){
      
      if(data == "OK" ){
      document.getElementById("errMsg1").innerHTML="";
          document.getElementById("errMsg1").style.display='none';
      ret = true;
      $.ajaxSetup({async:true});
      $.post("./check.php?check=3", { },function(data){
        $("#pb1").progressBar(40);
        a("desc").innerHTML="<?php echo $l['writedb'];?>";
        $.post("./check.php?check=4", { baseurl: a('baseurl').value, title: a('title').value, description: a('description').value, username: a('username').value, password: a('password').value, email: a('email').value },function(data){
        $("#pb1").progressBar(60);
        a("desc").innerHTML="<?php echo $l['writeconfig'];?>";
        $.post("./check.php?check=5", { },function(data){
        $("#pb1").progressBar(80);
        a("desc").innerHTML="<?php echo $l['writehtaccess'];?>";
        $.post("./check.php?check=6", { },function(data){
        $("#pb1").progressBar(100);
        a("desc").innerHTML="<?php echo $l['writefinished'];?>"
      });
      });
      });
      });
      }
      else{
      document.getElementById("errMsg2").innerHTML="There was a problem with the connection to the database";
      $("#errMsg2").effect("highlight");

      ret = false;
      }});
      break;
      case 4:
      $.ajaxSetup({async:true});
      $.post("./check.php?check=7", { },function(data){
	a('files').innerHTML = data;
	});
	a('finaldesc').innerHTML = '<p>Now you can access to your new website at <a href="'+a('baseurl').value+'">'+a('baseurl').value+'</a> with your username: '+a('username').value;
      ret = true;
      break;
	case 5:
      
      ret = true;
      break;
    default:
    alert('fuck');
        ret = true;
      break;
  }
  return ret;
}

</script>
</head><body>
<center>
    <h1>AneCMS - Installer</h1>
    <h2>Version 1.0 BETA</h2>
	</center>
	<div id="smartwizard" class="wiz-container">
		<ul id="wizard-anchor">
			<li><a href="#wizard-1"><h3>Step 1</h3>
          <small>Select Language</small></a></li>
			<li><a href="#wizard-2"><h2>Step 2</h2>
          <small>Check Permissions</small></a></li>
			<li><a href="#wizard-3"><h2>Step 3</h2>
          <small>WebSite Informations</small></a></li>
			<li><a href="#wizard-4"><h2>Step 4</h2>
          <small>Database Informations</small></a></li>
          <li><a href="#wizard-5"><h2>Step 5</h2>
          <small>Installation...</small></a></li>
          <li><a href="#wizard-6"><h2>Step 6</h2>
          <small>Completed</small></a></li>

		</ul> 
		<div id="wizard-body" class="wiz-body">
		<div id="wizard-6" >
           <div class="wiz-content">
                <div id="files"></div>
		<div id="finaldesc"></div>
            </div>        
            <div class="wiz-nav">
             <div id="errMsg22" class="error" ></div> <input class="next btn" id="next" type="button" value="Next >" />
            </div>          
        </div>
		<div id="wizard-5" >
           <div class="wiz-content">
                <span class="progressBar" id="pb1"></span>
                <div id="desc"><?php echo $l['createfolders'];?></div>
            </div>        
            <div class="wiz-nav">
             <div id="errMsg22" class="error" ></div> <input class="next btn" id="next" type="button" value="Next >" />
            </div>          
        </div>
		
  			<div id="wizard-4" >
  			   <div class="wiz-content">
                <h2>Database Informations</h2>	
                <br /><br /><br />
                <table align="center">
                  <tr>
                    <td>DB Hostname:</td>
                    <td><input type="text" name="dbhostname" id="dbhostname" value="localhost"/></td>
                  </tr>
                  <tr>
                    <td>DB Username:</td>
                    <td><input type="text" name="dbusername" id="dbusername" value=""/></td>
                  </tr>
				  <tr>
                    <td>DB Password:</td>
                    <td><input type="password" name="dbpassword" id="dbpassword" value=""/></td>
                  </tr>
				  <tr>
                    <td>DB Database:</td>
                    <td><input type="text" name="dbdatabase" id="dbdatabase" value="anecms"/></td>
                  </tr>
                  <tr>
                    <td>TBL Prefix:</td>
                    <td><input type="text" name="prefix" id="prefix" value="ANE_"/></td>
                  </tr>                                
                </table>
            </div>        
            <div class="wiz-nav">
			<input class="back btn" id="back" type="button" value="< Back" />
             <div id="errMsg2" class="error" ></div> <input class="next btn" id="next" type="button" value="Install >" />
            </div>          
        </div>
  			<div id="wizard-3">
  			   <div class="wiz-content">
                <h2>Basic Informations</h2>	
                <br /><br /><br />
                <table align="center">
                  <tr>
                    <td>BaseURL:</td>
                    <td><input type="text" name="baseurl" id="baseurl" value="<?php echo $pageurl; ?>" disabled="disabled"/></td>
                  </tr>
                  <tr>
                    <td>Site Title:</td>
                    <td><input type="text" name="title" id="title"/></td>
                  </tr>
				  <tr>
                    <td>Site Description:</td>
                    <td><input type="text" name="description" id="description"/></td>
                  </tr>
				  <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" id="username"/></td>
                  </tr>
                  <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="password"/></td>
                  </tr>        
                  <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" id="email"/></td>
                  </tr>                         
                </table>
            </div>  
            <div class="wiz-nav">
              <input class="back btn" id="back" type="button" value="< Back" />
			  <div id="errMsg1" class="error"></div> 
              <input class="next btn" id="next" type="button" value="Next >" />		       </div>                        
        </div>
  			<div id="wizard-2">
  			   <div class="wiz-content">
                <h2><?php echo $l['controls'];?></h2>	
                <br /><br /><br />
                
                <table align="center">
                  <tr>
                    <td colspan="2"><?php echo $l['fileperms'];?></td>
                    <td>
                  </tr>
                  <tr>
                  <td colspan="2"><table id="t">
            <?php echo checkPerms();?>
          </table></td>
                  </tr>
                                                  
                </table>
            </div>           
            <div class="wiz-nav">
              <input class="back btn" id="back" type="button" value="< Back" />
              <div id="errMsgx" class="error" ></div> 
              <input class="next btn" id="next" type="button" value="Next >" />            </div>             
        </div>
        <div id="wizard-1">
  			   <div class="wiz-content">
                <h2><?php echo $l['selectl'];?></h2>  
                <br /><br /><br />
                <table align="center">
                  <tr>
                    <td>DB Hostname:</td>
                    <td><?php echo getLanguages(); ?></td>
                  </tr>
            </div>            
            <div class="wiz-nav">
              <input class="back btn" id="back" type="button" value="< Back" />
              <input class="next btn" id="next" type="button" value="Next >" />
            </div>             
        </div>
    </div>
	</div>

</body></html>
<?php } ?>
