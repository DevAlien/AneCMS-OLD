<?php
/**
 * This class is the First class in each Page for the Debug
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * This class is the First class in each Page for the Debug
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Init {

    /**
     * Microtime when the page start to load
     *
     * @var integer
     */
    private $time_start;

    /**
     * Microtime when the page end to load
     *
     * @var integer
     */
    private $time_end;

    /**
     * Constructor, start microtime
     *
     */
    function __construct() {
		global $serverinfos;
        $this->time_start = $this->getMicrotime();
        $this->setErrors();
		if($serverinfos['mod_rewrite'] == false && !defined('ANECMSACP') && !defined('LOGIN') && !defined('XMLRPC')){
			include(dirname(__FILE__).'/modrewrite.class.php');
			$ModRewrite = new ModRewrite();
			$ModRewrite->htaccess = dirname(__FILE__)."/../htaccess.rew";
			$todo = $ModRewrite->rewrite();
			$_GET = array_merge($todo["vars"],$_GET);
		}
    }

    /**
     * Get Infos: Generation Page, Queries and Memory Usage
     *
     * @global Database $db
     * @global array $lang
     * @return html
     */
    public function infos() {
        global $db, $lang;
        $this->time_end = $this->getMicrotime();
        $time = $this->time_end - $this->time_start;
        return '<div>'.$lang['gen-time'].'&nbsp;'.sprintf("%0.4f", $time).'s | '.$lang['queries'].'&nbsp;'.$db->nQuery().' | Cached Queries: '. $db->nCachedQuery().' | '.$lang['memory_usage'].'&nbsp;'.sprintf('%0.3f', memory_get_usage() / 1024 / 1024).'MB<br />'.$db->getQueries().'</div>';
    }

    /**
     * Return microtime
     *
     * @return decimal
     */
    private function getMicrotime() {
        list($usec, $sec) = explode(' ',microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * Load Language and Skin
     *
     * @global array $qgeneral
     * @global string $skin
     * @global array $lang
     * @global User $user
     */
    public static function loadBasicPreferences() {
        global $qgeneral, $skin, $lang, $user;
        if (is_object($user)) {
            include 'lang/'.$user->getValues('language').'/main.php';
            $skin = $user->getValues('skin');
        }
        else {
            include 'lang/'.$qgeneral['language'].'/main.php';
            $skin = $qgeneral['skin'];
        }
    }

    /**
     * Load Language and Skin of a AJAX page
     *
     * @global array $qgeneral
     * @global string $skin
     * @global array $lang
     * @global User $user
     */
    public static function loadAjaxPreferences() {
        global $qgeneral, $skin, $lang, $user;
        if (is_object($user)) {
            include '../../lang/'.$user->getValues('language').'/main.php';
            $skin = $user->getValues('skin');
        }
        else {
            include '../../lang/'.$qgeneral['language'].'/main.php';
            $skin = $qgeneral['skin'];
        }
    }

    /**
     * Load Language and Skin of a ACP page
     *
     * @global array $qgeneral
     * @global string $skin
     * @global array $lang
     * @global User $user
     */
    public static function loadACPPreferences() {
        global $qgeneral, $skin, $lang, $user;

        if (isset($user)) {
            include '../lang/'.$user->getValues('language').'/admin.php';
            $skin = $qgeneral['acp_skin'];
        }
        else {
            include '../lang/'.$qgeneral['language'].'/admin.php';
            $skin = $qgeneral['acp_skin'];
            $_SESSION['langu'] = $qgeneral['language'];
            $_SESSION['acp_skin'] = $qgeneral['skin'];
        }
    }
    
    /**
     * Load Database class
     *
     * @global array $database
     * @param String $type Type of database
     * @return Database
     */
    public function selectTypeDatabase($type) {
        global $database;
        if(include 'db/' . $type . '.class.php')
            return new DBDriver($database['server'], $database['user'], $database['password'], $database['name']);
        else {
            die($lang['nodbdriver']);
        }
    }

    public function checkCookie(){
        if(isset($_COOKIE['ANECMSUser'])){
            $user = unserialize($_COOKIE['ANECMSUser']);
            if(is_a($user, 'User')){
                $user->setArrayGroups();
                $_SESSION['logged'] = serialize($user);
                $_SESSION['token'] = Tools::getToken();
                $_SESSION['language'] = $user->getValues('language');
                return $user;
            }
            return null;
        }
        return null;
    }
    
    private function setErrors(){
      error_reporting ( E_ALL ) ;
      set_error_handler ( array( &$this, 'onGlobalError'), E_ALL ) ;
    }
    
    public function onGlobalError ( $error_code, $error_string, $error_file, $error_line, $return_only = false )
{
  global $debug;

if ( class_exists ( 'SystemErrors' ) )
{
$erros_man = new SystemErrors ( ) ;
return $erros_man->onGlobalError ( $error_code, $error_string, $error_file, $error_line, $return_only ) ;
}
else
{
include_once 'systemerrors.class.php' ;
$erros_man = new SystemErrors ( ) ;
return $erros_man->onGlobalError ( $error_code, $error_string, $error_file, $error_line, $return_only ) ;
}
}

}
?>
