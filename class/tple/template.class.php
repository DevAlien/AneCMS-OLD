<?php
/**
 * This Class parse the variables in one array
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * This Class parse the variables in one array
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Template {

    /**
     * Content of all Variables
     *
     * @var array
     */
    private $variables;

    /**
     * Directory of Template (skins)
     *
     * @var string
     */
    private $tpl_base = './skins/';

    /**
     * The directory of the templates directory
     *
     * @var string
     */
    private $tpl_dir;

    /**
     * Masterpage of template
     *
     * @var string
     */
    private $masterpage;

    /**
     * array with the widgets for loading
     *
     * @var array
     */
    private $widgets = array();

    /**
     * Array with javascripts paths
     *
     * @var array
     */
    private $javascripts = array();

    /**
     * array with css paths
     *
     * @var array
     */
    private $css = array();

    /**
     * String with the array to load
     *
     * @var string
     */
    private $onloadjs = '';

    /**
     * String with the html neccessary for cms working
     *
     * @var string
     */
    private $systemhtml = '';

    /**
     * String with the title of the page
     *
     * @var string
     */
    private $title = '';

    /**
     * String with the content of file to write in the cache file
     *
     * @var String
     */
    private $compiledFile;

    /**
     * Array with the contents parts for insert to the masterpage
     *
     * @var array
     */
    private $fileContent = array();

    /**
     * name of page
     *
     * @var string
     */
    private $name;

    /**
     * Set directory of Template and masterpage.
     *
     * @param string $template_dir Directory of Template
     *
     * @return Void
     */
    public function __construct($template_name, $default = true) {
        $this->name = $template_name;
        if($default == true)
            $this->tpl_dir = $this->tpl_base.$this->name;
        else
            $this->tpl_dir = $this->name;
        $this->masterpage = $this->tpl_dir.'/master.page';
        if(defined('ACP'))
          $this->tmpdir = '../tmp/';
        else
          $this->tmpdir = './tmp/';
    }
    
    private function getCompiledDir(){
      return $this->tmpdir.str_replace('./', 'cache/',$this->tpl_dir);
    }
public function setTplDir($tpldir, $tplname){
      $this->name = $tplname;
      $this->tpl_dir = $tpldir;
        $this->masterpage = $this->tpl_dir.'/master.page';
    }
    //TODO: add inCompileTpl
    /**
     * Compile the masterpage with the content of the tpl page and add the title, js and css, widgets etc.
     *
     * @return Void
     */
    private function compileMasterpage() {
        $this->compiledFile = file_get_contents($this->masterpage);
        $this->compileTPL($this->tpl_dir, 'master.page', true);
        $this->prepareWidgets();
        $this->compiledFile = $this->compiledFile;
        $this->compiledFile = preg_replace('/{title}/', $this->getTitle(), $this->compiledFile);
        $this->compiledFile = preg_replace_callback('/{jsandcss(?:\s+)js="(.*?)"(?:\s+)css="(.*?)"}/', array( &$this, 'getJSAndCSS'), $this->compiledFile);
        $this->compiledFile = preg_replace('/{onloadjs}/', $this->getOnLoadJS(), $this->compiledFile);
        $this->compiledFile = preg_replace('/{systemhtml}/', $this->getSystemHTML(), $this->compiledFile);
        $this->compiledFile = preg_replace_callback('/(?:{content(?:\s+)name="(.*?)"}([\S|\s]*?){\/content})/', array( &$this, 'loadContent'), $this->compiledFile);
        $this->compiledFile = preg_replace_callback('/(?:{widgets(?:\s+)area="(.*?)"})/', array( &$this, 'loadWidgets'), $this->compiledFile);
    }
    /**
     * Assign variable to a template
     *
     * @param string $variable_name Name of variable in template
     * @param mixed $value Value of variable assigned
     *
     * @return Void
     */
    public function assign($variable_name, $value) {
        global $variables;
        $this->variables[ $variable_name ] = $value;
    }

    private function preparePage() {

    }

    /**
     * Delete old compiled file and compile a new file
     *
     * @param string $template_dir Directory of template
     * @param string $tpl_name Name of template
     * @param boolean $withMasterpage if you can use the masterpage. Default is true
     *
     * @return Void
     */
    private function compileTPL($template_dir, $tpl_name, $withMasterpage) {
        if(is_writable( './tmp/cache/'.$template_dir))
            if($file = glob( $this->getCompiledDir() . '/' . $tpl_name . '*.php' ))
                foreach( $file as $delfile)
                    unlink($delfile);

        $tpl = file_get_contents($template_dir . '/' . $tpl_name);
        $compiling = preg_replace('/{title}/', $this->getTitle(), $tpl);
				$compiling = preg_replace('/{link\.{\$(.[^}]*?)\.(.*?)}}/', '<?php echo $qgeneral[\'url_base\'].(($serverinfos[\'mod_rewrite\'] == false) ? \'index.php?\' : \'\').str_replace(\'index.php\', \'\', $\\1[\'\\2\']);?>',$compiling);
		$compiling = preg_replace('/{link\.{\$(.*?)}}/', '<?php echo $qgeneral[\'url_base\'].(($serverinfos[\'mod_rewrite\'] == false) ? \'index.php?\' : \'\').str_replace(\'index.php\', \'\', $var[\'\\1\']); ?>',$compiling);
		$compiling = preg_replace('/{link\.(.*?)}/', '<?php echo $qgeneral[\'url_base\'].\'index.php?\\1\';?>',$compiling);
        $compiling = preg_replace('/{\$(.[^}]*?)\.(.*?)}/', '<?php echo $\\1[\'\\2\'];?>',$compiling);
        $compiling = preg_replace('/{\_(.[^}]*?)\.(.*?)}/', '<?php echo $var[\'\\1\'][\'\\2\'];?>',$compiling);
        $compiling = preg_replace('/{lang\.(.*?)}/', '<?php echo $lang[\'\\1\'];?>',$compiling);
		$compiling = preg_replace('/{link\.(.*?)}/', '<?php echo $qgeneral[\'url_base\'].\'index.php?\\1\';?>',$compiling);
        $compiling = preg_replace('/{qg\.(.*?)}/', '<?php echo $qgeneral[\'\\1\'];?>',$compiling);
        $compiling = preg_replace('/\[qg\.(.*?)\]/', '$qgeneral[\'\\1\']',$compiling);
        $compiling = preg_replace('/{user\.(.*?)}/', '<?php echo $user->getValues(\'\\1\');?>',$compiling);
        $compiling = preg_replace('/{uservar\.(.*?)}/', '$user->getValues(\'\\1\')',$compiling);
        $compiling = preg_replace('/\[\$(.[^]]*?)\.(.*?)\]/', '$\\1[\'\\2\']',$compiling);
        $compiling = preg_replace('/{Tools\:\:(.*?)\.(.*?)}/', '<?php echo Tools::\\1(\\2);?>',$compiling);
        $compiling = preg_replace('/{(.*?)\:\:(.*?)\.(.*?)}/', '<?php echo Tools::\\1(\\2);?>',$compiling);
        $compiling = preg_replace('/{\$key\.(.*?)}/', '<?php echo $key[\'\\1\'];?>',$compiling);
        $compiling = preg_replace('/{date\.\$(.*?)\.(.*?)}/', '<?php echo date(\'d-m-Y H:i\',$\\1[\'\\2\']);?>',$compiling);
        $compiling = preg_replace('/{date\.time}/', '<?php echo date(\'d-m-Y H:i\',time());?>',$compiling);
        $compiling = preg_replace('/{date\.(.*?)}/', '<?php echo date(\'d-m-Y H:i\',$var[\'\\1\']);?>',$compiling);
        $compiling = preg_replace('/{acplink\.(.*?)}/', '<?php echo ($qgeneral[\'acpajax\'] == 1) ? \'javascript:loadPage(\'\\1&ajax=1\')\' : \'\\1\'; ?>',$compiling);
        $compiling = preg_replace('/{filetree}/', '<?php echo php_file_tree(\'../skins/\',"javascript:loadTplToModify(\'[link]\',\'[ext]\',\'[fname]\',\'[chmod]\');"); ?>',$compiling);
        $compiling = preg_replace('/\[\$key\.(.*?)\]/', '$key[\'\\1\']',$compiling);
        $compiling = preg_replace('/\[\$value\]/', '$value',$compiling);
        $compiling = str_replace('{$value}', '<?php echo $value;?>',$compiling);
        $compiling = str_replace('{$key}', '<?php echo $key;?>',$compiling);
        $compiling = str_replace('{IFLOGGED}', '<?php if(is_a($user, \'User\')){?>',$compiling);
        $compiling = str_replace('{/IFLOGGED}', '<?php }?>',$compiling);
        $compiling = str_replace('{IFADMIN}', '<?php if(is_a($user, \'User\') && $user->getValues(\'groups\') == 3){?>',$compiling);
        $compiling = str_replace('{/IFADMIN}', '<?php }?>',$compiling);
        $compiling = str_replace('{IFNOTLOGGED}', '<?php if(!is_a($user, \'User\')){?>',$compiling);
        $compiling = str_replace('{/IFNOTLOGGED}', '<?php }?>',$compiling);
        $compiling = preg_replace('/{\$(.*?)}/', '<?php echo $var[\'\\1\'];?>',$compiling);
        $compiling = preg_replace('/\[\$(.*?)\]/', '$var[\'\\1\']',$compiling);
        $compiling = preg_replace('/{(.*?)\:\:(.*?)}/', '<?php echo \\1::\\2;?>',$compiling);
        $compiling = preg_replace('/\[counter.(.*?)\]/', '$counter_\\1',$compiling);
        $compiling = preg_replace('/(?:{if(?:\s+)condition="(.*?)"})/', '<?php if(\\1){ ?>',$compiling);
        $compiling = preg_replace('/(?:{elseif(?:\s+)condition="(.*?)"})/', '<?php } else if(\\1){ ?>',$compiling);
        $compiling = str_replace('{else}', '<?php } else{ ?>',$compiling);
        $compiling = str_replace('{/if}', '<?php } ?>',$compiling);
        $compiling = preg_replace('/(?:{loop(?:\s+)name="(.*?)"})/', '<?php $counter_\\1=0; foreach($var[\'\\1\'] as $key => $\\1){ $counter_\\1++; ?>',$compiling);
        $compiling = str_replace('{/loop}', '<?php } ?>',$compiling);
		$compiling = preg_replace_callback('/{jsandcss(?:\s+)js="(.*?)"(?:\s+)css="(.*?)"}/', array( &$this, 'getJSAndCSS'), $compiling);
        if($tpl_name != 'master.page')
            $compiling = preg_replace_callback('/(?:{content(?:\s+)name="(.*?)"}([\S|\s]*?){\/content})/', array( &$this, 'setFileContent'), $compiling);

        $this->compiledFile = $compiling;
    }

    /**

     *
     * @return Void
     */
    /**
     * Compile template, HTML to PHP
     * @global array $lang
     * @global User $user
     * @global array $qgeneral
     * @global Database $db
     * @global array $database
     * @param string $tpl_name Name of file to compile
     * @param string $ext Extension of file to compile
     * @param boolean $withMasterpage if you can use the masterpage. Default is true
     * @param boolean $echo if you can cache the file and after include it or print the compiled template
     */
    public function burn($tpl_name, $ext, $withMasterpage = true, $echo = false) {
        global $lang, $user, $qgeneral, $db, $database, $skin, $serverinfos;
        $var = $this->variables;
        if(!file_exists($this->tpl_dir . '/' . $tpl_name . '.' . $ext)) {
            echo 'The system tried to use the file: '. $this->tpl_dir . '/' . $tpl_name . '.' . $ext .' but doesn\'t exists<br /><br />Return to the <a href="'.$qgeneral['url_base'].'">site</a>';
            exit();
        }
        $tpltime = filemtime($this->tpl_dir . '/' . $tpl_name . '.' . $ext);
        if(file_exists($this->masterpage))
            $mastertime = filemtime($this->masterpage);
        else
            $mastertime = 0;
        if($echo == false) {
            if (file_exists($this->getCompiledDir() . '/' . $tpl_name . '.' . $ext . '_' . $tpltime . '_' . $mastertime . '.php'))
                include $this->getCompiledDir() . '/' . $tpl_name . '.' . $ext . '_' . $tpltime . '_' . $mastertime . '.php';
            else {
                $this->compileTPL($this->tpl_dir, $tpl_name . '.' . $ext, $withMasterpage);
                if($withMasterpage == true) {
                    $theme = $db->query('SELECT css FROM '.$database['tbl_prefix'].'dev_themes where name = ?', DBDriver::AARRAY, array($this->name));
                    if($theme['css'] != '') $this->addCSSFile($theme['css']);
                    $this->compileMasterpage();
                }
                if(is_writable($this->getCompiledDir() . '/')) {
//                    if(is_file($this->tpl_dir.'/../../class/HTML.php'))
//                        include $this->tpl_dir.'/../../class/HTML.php';
//                    else
//                        include $this->tpl_dir.'/../../../class/HTML.php';
//                    fwrite( fopen( $this->tpl_dir . '/Compiled/' . $tpl_name . '.' . $ext . '_' . $tpltime . '_' . $mastertime . '.php', 'w' ), Minify_HTML::minify($this->compiledFile) );
                    fwrite( fopen( $this->getCompiledDir() . '/' . $tpl_name . '.' . $ext . '_' . $tpltime . '_' . $mastertime . '.php', 'w' ), $this->compiledFile );
                    include $this->getCompiledDir() . '/' . $tpl_name . '.' . $ext . '_' . $tpltime . '_' . $mastertime . '.php';
                }
                else{
                  mkdir($this->getCompiledDir() . '/',0777, true);
                    eval('?>'.$this->compiledFile);
                }
            }
        }
        else
            echo $this->compiledFile;
    }

    /**
     * Prepare the widgets for the template
     *
     * @global Database $db
     * @global array $database
     * @return Void
     */
    private function prepareWidgets() {
        global $db, $database;

        $WidgetsList = $db->query('Select '.$database['tbl_prefix'].'dev_themewidgets.widgetarea, '.$database['tbl_prefix'].'dev_themewidgets.widgetname From '.$database['tbl_prefix'].'dev_themewidgets Inner Join '.$database['tbl_prefix'].'dev_themes On '.$database['tbl_prefix'].'dev_themewidgets.idtheme = '.$database['tbl_prefix'].'dev_themes.id WHERE '.$database['tbl_prefix'].'dev_themes.name = ? ORDER BY '.$database['tbl_prefix'].'dev_themewidgets.position asc ', DBDriver::ALIST, array($this->name));
        foreach($WidgetsList as $key => $value)
            $this->widgets[$value['widgetarea']][] = $value['widgetname'];
    }

    /**
     * Load Widgets for a area
     *
     * @param string $area The name of the widgetarea
     * @return string
     */
    private function loadWidgets($area) {
        $widgets = '';
        if(array_key_exists($area[1], $this->widgets))
        foreach($this->widgets[$area[1]] as $value)
            $widgets .= '<?php include \'./widgets/'.$value.'/index.php\'; ?>';
        return $widgets;
    }

    /**
     * Set the content of the "contents" in the fileContent array
     *
     * @param Array $content
     * @return String
     */
    private function setFileContent($content) {
        $this->fileContent[$content[1]] = $content[2];
        return $content[2];
    }

    /**
     * I don't know
     *
     * @param Array $matches
     * @return string
     */
    private function addMasterParts($matches) {
        $this->masterparts[] = $matches[1];

        return $matches[0];

    }

    /**
     * Set javascript files to add in the masterpage
     *
     * @param String $jsfile Path of javascript file
     */
    public function addJavascript($jsfile) {
        $this->javascripts[] = $jsfile;
    }

    /**
     * Set css files to add in the masterpage
     *
     * @param String $cssfile Path of javascript file
     */
    public function addCSSFile($cssfile) {
        $this->css[] = $cssfile;
    }

    /**
     * Set the title of the page
     *
     * @param string $title title of the page
     * @return Void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     *
     * @param <type> $pagename the name of the page to go modify
     */
    public function setPageName($pagename) {
        $this->name = $pagename;
    }

    /**
     * Get js and css strings
     *
     * @global array $qgeneral
     * @return String
     */
    private function getJSAndCSS($jsi) {
        global $qgeneral, $lang;
        $html = '';
        $cssws = '';
        $jsws = '';
        foreach($this->css as $css)
            $cssws .= $css.'|';
		if(strlen($jsi[2]) == 0)
			$cssws = rtrim($cssws, '|');
        $html .= '<link rel="stylesheet" type="text/css" href="'.$qgeneral['url_base'].'system/pages/bootstrap.css.php?'.$cssws.$jsi[2].'" media="screen"/> ';
        foreach($this->javascripts as $js)
            $jsws .= $js.'|';
		if(strlen($jsi[1]) == 0)
			$jsws = rtrim($jsws, '|');
        $html .= '<script type="text/javascript" src="'.$qgeneral['url_base'].'system/pages/bootstrap.js.php?'.$jsws.$jsi[1].'"></script>';

        return $html;
    }

    /**
     *Get the title of the page
     *
     * @global array $qgeneral
     * @return String
     */
    private function getTitle() {
        global $qgeneral;
        return $qgeneral['title']. ' ' . $this->title . ' - Powered By ANECMS';
    }

    /**
     * Load the contents
     *
     * @param array $matches
     * @return String
     */
    private function loadContent($matches) {
        if(array_key_exists($matches[1], $this->fileContent))
            return $this->fileContent[$matches[1]];

        return $matches[2];
    }

    /**
     * Add something to load at the startup
     *
     * @param string $onLoadJS string with js to load on startup
     */
    public function addOnLoadJS($onLoadJS) {
        $this->onloadjs .= ' '. $onLoadJS;
    }

    /**
     * Get JS to load at the startup
     *
     * @return string
     */
    private function getOnLoadJS() {
        $widget = new Widget();
        $widgetsjs = $widget->getWidgetsJS();
        if($widgetsjs != '')
            $in = '<input name="widgetsContent" type="hidden" />';
        else
            $in = '';
        return $in.'
                    <script type="text/javascript">
                    '.$widgetsjs.' $(function()
			{
		    '.$this->onloadjs.'});</script>';
    }

    /**
     * Add HTML strings from the core
     *
     * @param <type> $syshtml
     */
    public function addSystemHTML($syshtml) {
        $this->systemhtml .= $syshtml;

    }

    /**
     * Get HTML strings from the core
     *
     * @return string
     */
    private function getSystemHTML() {
        return $this->systemhtml;
    }
}
?>