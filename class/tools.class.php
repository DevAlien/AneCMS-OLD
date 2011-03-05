<?php
/**
 * Tools for basics operations
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Tools for basics operations
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Tools {

    /**
     * Anti sql/html injection
     *
     * @param string $str string of text to check
     * @param boolean $bbcode if check also bbcode
     * @return string
     */
    public static function parseGetPost($str, $bbcode = false) {
        $str = str_replace  ( ">", "&gt;", $str );
        $str = str_replace  ( "<", "&lt;", $str );
        if($bbcode == true)
            $str = self::bbcode($str);
        if(get_magic_quotes_gpc())
            return $str;
        else
            return @mysql_real_escape_string($str);
    }

    /**
     * Transfor BBCODE in HTML
     *
     * @param string $str String to convert
     * @param boolean $html If true use function htmlspecialchars
     * @return string
     */
    public static function bbcode($str, $html = false) {
        global $lang;

        $bbcode_search = array(
                '/\[b\](.*?)\[\/b\]/is',
                '/\[i\](.*?)\[\/i\]/is',
                '/\[u\](.*?)\[\/u\]/is',
                '/\[title\](.*?)\[\/title\]/is',
                '/\[subtitle\](.*?)\[\/subtitle\]/is',
                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
                '/\[url\](.*?)\[\/url\]/is',
                '/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
                '/\[img\](.*?)\[\/img\]/is',
                '/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
                '/\[mail\](.*?)\[\/mail\]/is',
                '/\[font\=(.*?)\](.*?)\[\/font\]/is',
                '/\[size\=(.*?)\](.*?)\[\/size\]/is',
                '/\[color\=(.*?)\](.*?)\[\/color\]/is',
                '/\[quote\=(.*?)\](.*?)\[\/quote\]/is',
                '/\[quote\](.*?)\[\/quote\]/is',
                '/\[code\](.*?)\[\/code\]/is',
                '/\[list\=(.*?)\](.*?)\[\/list\]/ms',
                '/\[list\](.*?)\[\/list\]/ms',
                '/\[\*\]\s?(.*?)\n/ms'
        );

        $bbcode_replace = array(
                '<strong>$1</strong>',
                '<em>$1</em>',
                '<u>$1</u>',
                '<h1>$1</h1>',
                '<h2>$1</h2>',
                '<a href="$1" target="_blank">$2</a>',
                '<a href="$1" target="_blank">$1</a>',
                '<div style="text-align: $1;">$2</div>',
                '<img src="$1" alt="$1"/>',
                '<a href="mailto:$1">$2</a>',
                '<a href="mailto:$1">$1</a>',
                '<span style="font-family: $1;">$2</span>',
                '<span style="font-size: $1;">$2</span>',
                '<span style="color: $1;">$2</span>',
                '<br />$1 <blockquote>$2</blockquote>',
                '<blockquote>$1</blockquote>',
                '<iframe src="http://highlighter.anecms.com/$1/1" width="100%" height="350px"></iframe>',

                '<ol start="\1">\2</ol>',
                '<ul>\1</ul>',
                '<li>\1</li>'
        );

        $str = preg_replace ($bbcode_search, $bbcode_replace, $str);

        return nl2br($str);
    }

    public static function htmlToBBCode($str) {
        $bbcode_replace = array(
                '[b]$1[/b]',
                '[i]$1[/i]',
                '[u]$1[/u]',
                '[title]$1[/title]',
                '[subtitle]$1[/subtitle]',
                '[mail=$1]$2[/mail]',
                '[url=$1]$2[/url]',
                '[align=$1]$2[/align]',
                '[img]$1[/img]',
                '[font=$1]$2[/font]',
                '[size=$1]$2[/size]',
                '[color=$1]$2[/color]',
                '[quote=$1]$2[/quote]',
                '[quote]$1[/quote]',
                '[code]$1[/code]',
                '[list=$1]$2[/list]',
                '[list]$1[/list]',
                "[*] $1\n",
                ''
        );

        $bbcode_search = array(
                '/\<strong\>(.*?)\<\/strong\>/is',
                '/\<em\>(.*?)\<\/em\>/is',
                '/\<u\>(.*?)\<\/u\>/is',
                '/\<h1\>(.*?)\<\/h1\>/is',
                '/\<h2\>(.*?)\<\/h2\>/is',
                '/\<a href\=\"mailto:(.*?)\"\>(.*?)\<\/a\>/is',
                '/\<a href\=\"(.*?)\"\ target\=\"_blank\">(.*?)\<\/a\>/is',
                '/\<div style\=\"text-align: (left|center|right);\"\>(.*?)\<\/div\>/is',
                '/\<img src\=\"(.*?)\" alt\=\"(.*?)\"\\/\>/is',
                '/\<span style\=\"font-family: (.*?);\"\>(.*?)\<\/span\>/is',
                '/\<span style\=\"font-size: (.*?);\"\>(.*?)\<\/span\>/is',
                '/\<span style\=\"color: (.*?);\"\>(.*?)\<\/span\>/is',
                '/\<br \/\>(.*?) \<blockquote\>(.*?)\<\/blockquote\>/is',
                '/\<blockquote\>(.*?)\<\/blockquote\>/is',
                '/\<iframe src\=\"http:\/\/highlighter.anecms.com\/(.*?)\/1\" width\=\"100%\" height\=\"350px\"\>\<\/iframe\>/is',
                '/\<ol start\=\"(.*?)\"\>(.*?)\<\/ol\>/is',
                '/\<ul\>(.*?)\<\/ul\>/is',
                '/\<li\>(.*?)\<\/li\>/ms',
                '/\<br \/\>/is'
        );

        $str = preg_replace ($bbcode_search, $bbcode_replace, $str);
        return $str;
    }
    /**
     * Anti Sql-Injection
     *
     * @param string $msg String to check
     * @return string
     */
    public static function string_escape($msg) {
        if(get_magic_quotes_gpc())
            return $msg;
        else
            return @mysql_real_escape_string($msg);
    }

    /**
     * Escape a string
     *
     * @param string $msg
     * @return string
     */
    public static function string_escapeForce($msg) {
        return @mysql_real_escape_string($msg);
    }

    /**
     * Check if the email can be true
     *
     * @param string $email Email to check
     * @return boolean
     */
    public static function checkEmail($email) {
        return eregi("^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$", $email);
    }

    /**
     * Check if to strings are equals
     *
     * @param string $val1
     * @param string $val2
     * @return boolean
     */
    public static function checkIfEquals($val1, $val2) {
        if($val1 == $val2)
            return true;
        else
            return false;
    }

    /**
     * Clean a url for a title
     *
     * @param string $title Title to parse
     * @return String
     */
    public static function parseTitle($title) {
        $title = str_replace("/", "", $title);
        $title = str_replace("&", "", $title);
        $title = str_replace(":", "", $title);
        $title = str_replace("_", "", $title);
        $title = str_replace("-", "", $title);
        $title = str_replace(".", "", $title);
        $title = str_replace("!", "", $title);
        $title = str_replace("?", "", $title);
        $title = str_replace(",", "", $title);
        $title = str_replace("#", "", $title);
        $title = str_replace("*", "", $title);
        $title = str_replace(" ", "-", $title);
        return $title;
    }

    public static function shortUrl($url) {
        $urle = urlencode($url);
        $e = file_get_contents('http://tinyurl.com/api-create.php?url='.$urle);
        if($e != "")
            return $e;
        else
            return $url;
    }
    
	public static function getToken() 
	{
		if( isset($_SESSION['token']) ) {
			return $_SESSION['token'];
		} else {
			return md5(uniqid(rand(), TRUE));
		}
	}
	
	public static function checkToken() 
	{
		if( isset($_POST['csrftoken']) && isset($_SESSION['token']) && ($_POST['csrftoken'] == $_SESSION['token']) ) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function sanitizeRequest( $content = '' )
	{
		if( is_null($content) || $content == '')
			return null;
		if( is_array($content) )
			foreach ($content as $key => $value) $content[$key] = sanitizeRequest( $value );
		else
			return stripcslashes( $content );
	}
	
	public static function timeElapsed ($time){
		global $lang;
	    $time = time() - $time;
	
	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 	'month',
	        604800 => 	'week',
	        86400 => 	'day',
	        3600 => 	'hour',
	        60 => 		'minute',
	        1 => 		'second'
	    );
	
	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits .' '. (( $numberOfUnits > 1 )? $lang[$text.'s'] : $lang[$text]);
	    }
	}
	
	public static function timeTo ($time){
		global $lang;
	    $time = $time - time();
	
	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 	'month',
	        604800 => 	'week',
	        86400 => 	'day',
	        3600 => 	'hour',
	        60 => 		'minute',
	        1 => 		'second'
	    );
	
	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits .' '. (( $numberOfUnits > 1 )? $lang[$text.'s'] : $lang[$text]);
	    }
	}
	
	public static function cut( $string, $length, $ending = "..." ){
		if( strlen( $string ) > $length )
			return $string = substr( $string, 0, $length ) . $ending;
		else
			return $string = substr( $string, 0, $length );
	}
	
	public static function randStr($length = 5, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'){
	    $chars_length = (strlen($chars) - 1);
	    for ($i = 0; $i < $length; $i = strlen($string))
	        $string .= $chars{rand(0, $chars_length)};
	    return $string;
	}
	
	public static function aneLoad( $fload )
	{
		if( is_array($fload) ) {
			foreach( $fload as $files) {
				
				if( file_exists($files) )
					require_once( $files );
				else 
					return "File doesn't exists";
			}
		} else {
				if( file_exists($fload) )
					require_once( $fload );
				else 
					return "File $fload doesn't exists";
		}
	}

}
?>
