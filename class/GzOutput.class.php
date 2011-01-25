<?php
/**
 * GzOutput class,
 *	simple class with some static method to create gz output without ob_gzhandler
 * ______________________________________________________________
 * @example
 * 	GzOutput::create('body{padding:0;}', 'text/css');			// css file
 *      	GzOutput::createNew('var something = "somevalue";', 'text/javascript');	// JS file without caching
 * 	GzOutput::createFromList(array('file.css', 'file2.css'), 'text/css');	// css file
 *	GzOutput::createNewFromList(array('file.css', 'file2.css'), 'text/css');	// css file without caching
 * --------------------------------------------------------------
 * @example using external "bootstrap.php" file (css example)
 *
 *	<link rel="stylesheet" href="css/bootstrap.css.php?base|tables|extra" media="screen" type="text/css" />
 *
 * 	<?php // css/bootstrap.css.php
 *	require '../classes/GzOutput.class.php';
 *	GzOutput::createFromFile(__FILE__, 'text/css');
 *	// single css file with: [css/base.css, css/tables.css, css/extra.css]
 *	 ?>
 * Please read over createFromFile method to know more
 * --------------------------------------------------------------
 * @Compatibility	PHP >= 5.X (E_ALL | E_STRICT) error free
 * @Author		Andrea Giammarchi
 * @Site		http://www.devpro.it/
 * @Date		2007/01/08
 * @Version		0.4 [new GzOutput::createFromFile static method, based on external "bootstrap.php" file]
 */
define('GzOutput_ACCEPT_ENCODING', isset($_SERVER['HTTP_ACCEPT_ENCODING']));
define('GzOutput_GZIP', GzOutput_ACCEPT_ENCODING && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false);
define('GzOutput_DEFLATE', GzOutput_ACCEPT_ENCODING && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') !== false);
class GzOutput {

	/**
	 * public static method,
	 *	exit showing created output using a compression level
	 *
	 *	GzOutput::create(output:String, type:String [, level:UIntRange(0,9)]):Void(exit)
	 *
	 * @param	String		the content to show
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8")
	 * @param	UInt		compression level from 0 to 9, default: 9
	 */
	static public function create($output, $type, $level = 9) {
        global $lang;
		$cache = !defined('GzOutput_NO_CACHE');
		$hash = '';
		if(
			extension_loaded('zlib') &&
			function_exists('gzencode') &&
			isset($_SERVER['HTTP_ACCEPT_ENCODING']) &&
			(GzOutput_GZIP || GzOutput_DEFLATE)
		) {
			switch(GzOutput_GZIP) {
				case true:
					$output = gzencode($output, $level, FORCE_GZIP);
					header('Content-Encoding: gzip');
					break;
				case false:
					$output = gzencode($output, $level, FORCE_DEFLATE);
					header('Content-Encoding: deflate');
					break;
			}
		}
		$hash = '"'.sha1($output).'"';
		if($cache) {
			header('ETag: '.$hash);
			
		}
		if($cache && isset($_SERVER['HTTP_IF_NONE_MATCH']) && $hash === $_SERVER['HTTP_IF_NONE_MATCH']) {
			header('HTTP/1.1 304 Not Modified');
			$output = "";
		}
		else
			header('Content-Length: '.strlen($output));
        header('Cache-Control: public');
		header('Content-Type: '.$type);
            exit($output);
	}

	/**
	 * public static method,
	 *	exit showing created output using an external "bootstrap.php" file
	 *
	 *	GzOutput::createFromFile(__FILE__:String [, type:String [, extension:String[, level:UIntRange(0,9) [, new:Boolean]]]]):Void(exit)
	 * @example
	 *	[bootstrap.php inside folder js]
	 *	<?php require '../classes/GzOutput.class.php'; GzOutput::createFromFile(__FILE__); ?>
	 *
	 *	[index.html]
	 *	<script type="text/javascript" src="js/bootstrap.php?jsfile1|jsfile2|otherjsFile|folder/jsFile3"></script>
	 *
	 * bootstrap.php file will read content of these files: js/jsfile1, js/jsfile2, js/otherjsFile.js, js/folder/jsFile3.js
	 *
	 * @param	String		external __FILE__ constant
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8"), default: 'text/javascript'
	 * @param	String		valid file extension, default: 'js'
	 * @param	UInt		compression level from 0 to 9, default: 9
	 * @param	Boolean		doesn't use cache or use it if present, default: false
	 */
	static public function createFromFile($__FILE__, $type = 'text/javascript', $ext = 'js', $level = 9, $new = false){
		if(($list = strpos($_SERVER['REQUEST_URI'], '?')) !== false)
			call_user_func(array('GzOutput', '__listToOutput'), $list = array_map(
				create_function('$f', 'return "'.dirname($__FILE__).'/".$f.".'.$ext.'";'),
				explode('|', substr($_SERVER['REQUEST_URI'], ++$list))
			), $type, $level, $new);
	}

        static public function createFromFileBoostrap($type = 'text/javascript', $ext = 'js', $level = 9, $new = false){
		if(($list = strpos($_SERVER['REQUEST_URI'], '?')) !== false)
			call_user_func(array('GzOutput', '__listToOutput'), $list = array_map(
				create_function('$f', 'return "../../".$f."";'),
				explode('|', substr($_SERVER['REQUEST_URI'], ++$list))
			), $type, $level, $new);
	}


	/**
	 * public static method,
	 *	exit showing created output using an array with file names to read
	 *
	 *	GzOutput::createFromList(list:Array, type:String [, level:UIntRange(0,9)]):Void(exit)
	 *
	 * @param	Array		an array with one or more files to get contents to create the output
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8")
	 * @param	UInt		compression level from 0 to 9, default: 9
	 */
	static public function createFromList($list, $type, $level = 9) {
		call_user_func(array('GzOutput', '__listToOutput'), $list, $type, $level, false);
        }

	/**
	 * public static method,
	 *	exit showing created output using a compression level and removing cache problems
	 *
	 *	GzOutput::createNew(output:String, type:String [, level:UIntRange(0,9)]):Void(exit)
	 *
	 * @param	String		the content to show
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8")
	 * @param	UInt		compression level from 0 to 9, default: 9
	 */
	static public function createNew($output, $type, $level = 9) {
        global $lang;
		define('GzOutput_NO_CACHE', false);
		header('Expires: Mon, 26 Jul 2004 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: public');
//		header('Cache-Control: no-store, no-cache, must-revalidate');
//		header('Cache-Control: post-check=0, pre-check=0', false);
//		header('Pragma: no-cache');
		call_user_func(array('GzOutput', 'create'), $output, $type, $level);
	}

	/**
	 * public static method,
	 *	exit showing created output using an array with file names to read and removing cache problems
	 *
	 *	GzOutput::createNewFromList(list:Array, type:String [, level:UIntRange(0,9)]):Void(exit)
	 *
	 * @param	Array		an array with one or more files to get contents to create the output
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8")
	 * @param	UInt		compression level from 0 to 9, default: 9
	 */
	static public function createNewFromList($list, $type, $level = 9) {
		call_user_func(array('GzOutput', '__listToOutput'), $list, $type, $level, true);
        }

	/**
	 * private static method,
	 *	creates an output looping over list array and reading each file content.
	 *
	 *	GzOutput::__listToOutput(*list:Array, *type:String, *level:UIntRange(0,9) [, nocache:Boolean]):Void(exit)
	 *
	 * @param	Array		an array with one or more files to get contents to create the output
	 * @param	String		the Content-Type (i.e. "text/css", "text/javascript", "text/html; charset:UTF-8")
	 * @param	UInt		compression level from 0 to 9, default: 9
	 * @param	Boolean		doesn't use cache or use it if present
	 */
	static private function __listToOutput($list, $type, $level, $new) {
        global $lang;
        for($i = 0, $j = count($list); $i < $j; $i++)
			     $list[$i] = (file_exists($list[$i]) && is_readable($list[$i])) ? preg_replace('/{lang\.(.*?)}/', $lang['home'], file_get_contents($list[$i])) : '';
		call_user_func(array('GzOutput', $new ? 'createNew' : 'create'), implode("\r\n", $list), $type, $level);
	}
}
?>