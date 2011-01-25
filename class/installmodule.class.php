<?php
/**
 * Class to install modules
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Class to install modules
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class installModule {

    /**
     * Name of the module to install
     *
     * @var string
     */
    private $name;

    /**
     * Infos of module.def file, inclued on the package
     *
     * @var array
     */
    private $info = array();

    /**
     * Constructor only to load the name
     *
     * @param string $modulename The name of the module
     */
    public function __construct($modulename) {
        $this->name = $modulename;
    }

    /**
     * Install the module
     *
     * @global Database $db
     */
    function install() {
        global $db;
        $overwrite = true;
        include '../tmp/toinstall/'.$this->name.'.php';

        foreach( $directory as $dirname => $dir_param )
            if( !file_exists($dirname ) )
                mkdir($dirname, $dir_param['perms'] );

        foreach( $file as $filename => $file_param ) {

            if( !file_exists($filename ) or $overwrite ) {

                $fp = fopen($filename, "w" );
                $contents = base64_decode( $file_param['contents'] );
                $contents = gzuncompress( $contents );

                fwrite( $fp, $contents, strlen( $contents ) );
                fclose( $fp );
                chmod($filename, $file_param['perms'] );

            }
        }

        if($type == 'modules') {
            $this->loadLanguageFiles();

            $this->loadSQL();

            $this->setTemplateFiles();

            $this->setHtaccess();

            $this->getModuleDefinition();

            $this->dbInsert();

            $this->deleteInstaller();
        }
    }

    /**
     * Execute the SQL file on the package
     *
     * @global Database $db
     */
    private function loadSQL() {
        global $db, $database;
        if(file_exists('../modules/'.$this->name.'/install/module.sql'))
            $db->executeSqlFile(str_replace('##PREFIX##', $database['tbl_prefix'], file_get_contents('../modules/'.$this->name.'/install/module.sql')));
    }

    /**
     * Set the template files in all the directories that the cms has
     *
     * @global Databse $db
     * @global array $database
     */
    private function setTemplateFiles() {
        global $db, $database;
        if(file_exists('../modules/'.$this->name.'/install/tpl/'))
            $themes = $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_themes');
        foreach($themes as $key => $value) {
            if($value['type'] == 1)
                $this->copyTplFiles(1, '../skins/'.$value['name'].'/');
            else
                $this->copyTplFiles(2, './skins/'.$value['name'].'/');
        }
    }

    /**
     * Copy tpl files in the correct directory
     *
     * @param int $type Id of the type (1 = site tpl, 2 = acp tpl)
     * @param array $dest Destination of the file
     */
    private function copyTplFiles($type, $dest) {
        if($type == 1) {
            if ($handle = opendir('../modules/'.$this->name.'/install/tpl/normal/'))
                while (false !== ($file = readdir($handle)))
                    if (($file != "." && $file != "..") && !is_dir($file)){
                        copy('../modules/'.$this->name.'/install/tpl/normal/'.$file, $dest.$file);
                        chmod($dest.$file, 0777);
                    }
        }
        else
        if ($handle = opendir('../modules/'.$this->name.'/install/tpl/acp/'))
            while (false !== ($file = readdir($handle)))
                if (($file != "." && $file != "..") && !is_dir($file)){
                    copy('../modules/'.$this->name.'/install/tpl/acp/'.$file, $dest.$file);
                    chmod($dest.$file, 0777);
                }
    }

    /**
     * Load languages file of the package and copy the content into the correct language file
     */
    private function loadLanguageFiles() {
        if ($handle = opendir('../modules/'.$this->name.'/install/lang/')) {
            while (false !== ($file = readdir($handle))) {
                if (($file != "." && $file != "..") && !is_dir($file)) {
                    $fileric = explode('.', $file);
                    $filecontents = file_get_contents('../modules/'.$this->name.'/install/lang/'.$file);
                    $contentlangfile = file_get_contents('../lang/'.$fileric[1].'/'.$fileric[0].'.php');
                    $modifiedlangfile = str_replace('?>', $filecontents."\n\n?>", $contentlangfile);
                    file_put_contents('../lang/'.$fileric[1].'/'.$fileric[0].'.php', $modifiedlangfile);
                }
            }
        }
    }

    /**
     * Load the module.htaccess file and copy the content into the main .htaccess
     */
    private function setHtaccess() {
		global $serverinfos;
			if(file_exists('../modules/'.$this->name.'/install/module.htaccess'))
				if($serverinfos['mod_rewrite'] == true)
					file_put_contents('../.htaccess', "\n" . file_get_contents('../modules/'.$this->name.'/install/module.htaccess'), FILE_APPEND);
				else
					file_put_contents('../htaccess.rew', "\n" . file_get_contents('../modules/'.$this->name.'/install/module.htaccess'), FILE_APPEND);
    }

    /**
     * Delete the install directory and the package from the main directory
     */
    private function deleteInstaller() {
        rmdir('../modules/'.$this->name.'/install');
        unlink('../tmp/toinstall/'.$this->name.'.php');
    }

    /**
     * Get the defenition of the module and put on $info variable
     */
    private function getModuleDefinition() {
        $handle = @fopen('../modules/'.$this->name.'/install/module.def', 'r');
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);
                $line = spliti('=', $buffer, 2);
                $this->info[$line[0]] = rtrim($line[1]);
            }
            fclose($handle);
        }
    }

    /**
     * Insert into the db the new module
     *
     * @global Database $db
     * @global array $database
     */
    private function dbInsert() {
        global $db, $database;

        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_modules (name, description, status, type, version, author, email, site, datarelease, depends) VALUES (\''.$this->info['name'].'\', \''.$this->info['description'].'\', 1, 1, \''.$this->info['version'].'\', \''.$this->info['author'].'\', \''.$this->info['email'].'\', \''.$this->info['site'].'\', \''.$this->info['datarelease'].'\', \''.$this->info['depends'].'\' )');
		$db->delete_cache();
	}
}
?>