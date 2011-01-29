<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of installclass
 *
 * @author Gonçalo
 */

class Install {
    private $db;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $type = 'mysql';
    private $tbl_prefix = '';
    private $baseurl;
    private $lang;
    private $cfgfile = '';
    private $hacfile = '';
	private $hacrew = '';
	private $servertype = '';
	private $modrew = false;
	
    function  __construct($prefix, $lan) {
        $this->tbl_prefix = $prefix;
		$this->lang = $lan;
		$this->setServerType();
		$this->setModRew();
    }

	private function setServerType(){
		$srvt = $_SERVER['SERVER_SOFTWARE'];
		$srvt = explode('/', $srvt);
		$this->servertype = strtolower($srvt[0]);
	}
	
	private function setModRew(){
		if($this->servertype == 'apache')
			$this->modrew = in_array('mod_rewrite', apache_get_modules());
		else
			$this->modrew = false;
	}
    public function setDB($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->db = new DBDriver($hostname, $username, $password, $database);


    }
    
    public function checkDBConnection() {
        $this->db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA where SCHEMA_NAME = '".$this->database."'");
        if($this->db->affectedRows() > 0)
            return true;
        else
            return false;
    }

public function createFolders(){
  mkdir('../tmp/cache/sql', 0777, true);
  mkdir('../tmp/toinstall', 0777, true);
}
    public function writeDB($title, $desc, $purl) {
      $this->db = new DBDriver($this->hostname, $this->username, $this->password, $this->database);
      echo file_get_contents('sqlwp.sql');
        $sql = str_replace('##PREFIX##', $this->tbl_prefix, file_get_contents('sqlwp.sql'));
        echo $this->db->executeSqlFile($sql);
        $this->db->query("INSERT INTO ".$this->tbl_prefix."dev_general VALUES (0,'".$this->lang."',1,'".$title."', '".$desc."','default','register','".$purl."','admintasia',0,'','0.9','','','','The website is closed for some tests, Coming soon')");
       $this->db->query("INSERT INTO ".$this->tbl_prefix."dev_users VALUES (1, '".$_POST['username']."', '', '".md5($_POST['password'])."', '".$this->lang."', 'default', '3', '1', '')");
    }

    public function writeConfig() {

        $header = "<?php
                   /**
                   * File automaked with the installer of AneCMS
                   *
                   * @package AneCMS
                   * @author Goncalo Margalho <gsky89@gmail.com>
                   * @copyright anecms.Com (C) 2006-2008
                   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
                   * @version 000
                   */";

        $header .= "\n";
        $header .= '$database[\'server\'] = \''.$this->hostname.'\';';
        $header .= "\n";
        $header .= '$database[\'user\'] = \''.$this->username.'\';';
        $header .= "\n";
        $header .= '$database[\'password\'] = \''.$this->password.'\';';
        $header .= "\n";
        $header .= '$database[\'name\'] = \''.$this->database.'\';';
        $header .= "\n";
        $header .= '$database[\'type\'] = \''.$this->type.'\';';
        $header .= "\n";
        $header .= '$database[\'tbl_prefix\'] = \''.$this->tbl_prefix.'\';';
        $header .= "\n";
		$header .= '$serverinfos[\'type\'] = \''.$this->servertype.'\';';
        $header .= "\n";
		$header .= '$serverinfos[\'mod_rewrite\'] = \''.$this->modrew.'\';';
        $header .= "\n";
        $header .= '$debug = false;';
        $header .= "\n";
        $header .= '?>';

		if(is_writable('../')){
        $fp = fopen( '../config.php' , "a+" );
        fwrite( $fp, $header, strlen( $header ) );
		return false;
		}
		else
			$this->cfgfile = $header;
	}


    public function writeHtaccess() {
        $rb = str_replace('install/check.php?check=6', '', $_SERVER['REQUEST_URI']);
        $header = "ErrorDocument 404 ".$rb."error.php?error=404";
		$header1 = "
		RewriteEngine on
RewriteBase ".$rb."
RewriteRule ^\.htaccess$ - [F]

# Base Rules
RewriteRule ^acp$ acp/index.php
# Base Rules

# Start Rules Register
RewriteRule ^register$ index.php?mode=register
RewriteRule ^register/next(.*)$ index.php?mode=register&next
# End Rules Register
";
	if(is_writable('../')){
		if($this->modrew == true){
			$fp = fopen( '../.htaccess' , "a+" );
			fwrite( $fp, $header.$header1, strlen( $header.$header1 ) );
		}
		else{
			$fp = fopen( '../.htaccess' , "a+" );
			fwrite( $fp, $header, strlen( $header ) );
			
			$fp = fopen( '../htaccess.rew' , "a+" );
			fwrite( $fp, $header1, strlen( $header1 ) );
		}
return false;
}
	else{
		if($this->modrew == true){
			$this->hacfile = $header.$header1;
		}
		else{
			$this->hacfile = $header;
			$this->hacrew = $header;
		}
	}
}
public function getFiles(){
$var = '';
if($this->hacfile != ''){
$var .= '<p>You should copy the following code and paste it in a file called <i><b>.htaccess</b></i> the file must be in the root "./" of the cms, where you can find also index.php, rss.php and some folders.<br /><textarea width="100%">'.$this->hacfile.'</textarea></p>';
}
if($this->hacrew != ''){
$var .= '<p>You should copy the following code and paste it in a file called <i><b>htaccess.rew</b></i> the file must be in the root "./" of the cms, where you can find also index.php, rss.php and some folders.<br /><textarea width="100%">'.$this->hacrew.'</textarea></p>';
}

if($this->cfgfile != ''){
$var .= '<p>You should copy the following code and paste it in a file called <i><b>config.php</b></i> the file must be in the root "./" of the cms, where you can find also index.php, rss.php and some folders.<br /><textarea width="100%">'.$this->cfgfile.'</textarea></p>';
}
return $var;
}
}
?>
